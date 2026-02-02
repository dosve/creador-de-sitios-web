# 💻 Ejemplos de Código: Duplicar Sitio Web

## Ejemplo 1: Uso Básico desde Tinker

```php
php artisan tinker

// Obtener un sitio web
$website = \App\Models\Website::find(1);

// Duplicarlo
$service = app(\App\Services\DuplicateWebsiteService::class);
$newWebsite = $service->duplicate($website, 'Mi Sitio Nuevo');

// Ver resultado
echo "Nuevo sitio ID: " . $newWebsite->id;
echo "Nombre: " . $newWebsite->name;
echo "Páginas: " . $newWebsite->pages()->count();
```

## Ejemplo 2: Uso en Controlador Custom

```php
<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Services\DuplicateWebsiteService;
use Illuminate\Http\Request;

class MyController extends Controller
{
    public function duplicateForClient(Request $request, DuplicateWebsiteService $service)
    {
        $website = Website::find($request->website_id);
        
        try {
            $newWebsite = $service->duplicate(
                $website,
                "Copia para {$request->client_name}",
                $request->slug
            );
            
            // Enviar notificación
            // Email::send(...);
            
            return response()->json([
                'success' => true,
                'website_id' => $newWebsite->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
```

## Ejemplo 3: Duplicación con Validación Personalizada

```php
// En tu controlador
$validated = $request->validate([
    'name' => [
        'required',
        'string',
        'max:255',
        function ($attribute, $value, $fail) {
            // Validación personalizada
            if (strlen($value) < 3) {
                $fail('El nombre debe tener al menos 3 caracteres.');
            }
        }
    ],
    'slug' => [
        'nullable',
        'unique:websites,slug',
        'regex:/^[a-z0-9\-]+$/',
    ]
]);

$newWebsite = $this->duplicateWebsiteService->duplicate(
    $website,
    $validated['name'],
    $validated['slug']
);
```

## Ejemplo 4: Duplicación en Batch (CLI)

```php
<?php

namespace App\Console\Commands;

use App\Models\Website;
use App\Services\DuplicateWebsiteService;
use Illuminate\Console\Command;

class DuplicateWebsitesCommand extends Command
{
    protected $signature = 'websites:duplicate {--user-id= : ID del usuario}';
    protected $description = 'Duplicar todos los sitios de un usuario';

    public function handle(DuplicateWebsiteService $service)
    {
        $userId = $this->option('user-id');
        $websites = Website::where('user_id', $userId)->get();

        $this->info("Duplicando {$websites->count()} sitios...");

        foreach ($websites as $website) {
            try {
                $newWebsite = $service->duplicate(
                    $website,
                    "{$website->name} (Backup)"
                );
                
                $this->info("✓ {$website->name} → {$newWebsite->name}");
            } catch (\Exception $e) {
                $this->error("✗ Error en {$website->name}: " . $e->getMessage());
            }
        }

        $this->info("¡Duplicación completada!");
    }
}
```

## Ejemplo 5: Testing Unitario

```php
<?php

namespace Tests\Feature;

use App\Models\Website;
use App\Services\DuplicateWebsiteService;
use Tests\TestCase;

class DuplicateWebsiteTest extends TestCase
{
    private DuplicateWebsiteService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(DuplicateWebsiteService::class);
    }

    public function test_duplicate_website_with_all_relations()
    {
        $original = Website::factory()
            ->has(\App\Models\Page::factory()->count(5))
            ->has(\App\Models\Category::factory()->count(3))
            ->has(\App\Models\Tag::factory()->count(10))
            ->create();

        $duplicated = $this->service->duplicate(
            $original,
            'Duplicated Website'
        );

        // Assertions
        $this->assertNotEquals($original->id, $duplicated->id);
        $this->assertEquals('Duplicated Website', $duplicated->name);
        $this->assertFalse($duplicated->is_published);
        $this->assertEquals(
            $original->pages()->count(),
            $duplicated->pages()->count()
        );
        $this->assertEquals(
            $original->categories()->count(),
            $duplicated->categories()->count()
        );
        $this->assertNotEqual(
            $original->slug,
            $duplicated->slug
        );
    }

    public function test_slug_uniqueness()
    {
        $original = Website::factory()->create();

        $dup1 = $this->service->duplicate($original, 'Copia 1');
        $dup2 = $this->service->duplicate($original, 'Copia 2');

        $this->assertNotEqual($dup1->slug, $dup2->slug);
        $this->assertDatabaseCount('websites', 3);
    }

    public function test_duplicate_rolls_back_on_error()
    {
        $original = Website::factory()->create();
        $countBefore = Website::count();

        try {
            // Simular error
            $this->service->duplicate(
                $original,
                null // Debe fallar
            );
        } catch (\Exception $e) {
            // Es esperado
        }

        // La BD no debe cambiar
        $this->assertEquals($countBefore, Website::count());
    }
}
```

## Ejemplo 6: Testing End-to-End (HTTP)

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Website;
use Tests\TestCase;

class DuplicateWebsiteHttpTest extends TestCase
{
    private User $user;
    private Website $website;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->website = Website::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_show_duplicate_form()
    {
        $response = $this->actingAs($this->user)
            ->get(route('creator.websites.duplicate', $this->website));

        $response->assertStatus(200);
        $response->assertViewIs('creator.websites.duplicate');
        $response->assertViewHas('website', $this->website);
    }

    public function test_duplicate_website_post()
    {
        $response = $this->actingAs($this->user)
            ->post(route('creator.websites.duplicate.store', $this->website), [
                'name' => 'Nueva Copia',
                'slug' => 'nueva-copia'
            ]);

        $response->assertRedirect(route('creator.websites.show'));
        $this->assertDatabaseHas('websites', [
            'name' => 'Nueva Copia',
            'slug' => 'nueva-copia'
        ]);
    }

    public function test_unauthorized_user_cannot_duplicate()
    {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)
            ->post(route('creator.websites.duplicate.store', $this->website), [
                'name' => 'Hack'
            ]);

        $response->assertStatus(403);
    }

    public function test_validation_errors()
    {
        $response = $this->actingAs($this->user)
            ->post(route('creator.websites.duplicate.store', $this->website), [
                'name' => '', // vacío
            ]);

        $response->assertSessionHasErrors('name');
    }
}
```

## Ejemplo 7: Event/Listener para Auditoría

```php
<?php

namespace App\Events;

use App\Models\Website;
use Illuminate\Foundation\Events\Dispatchable;

class WebsiteDuplicated
{
    use Dispatchable;

    public function __construct(
        public Website $original,
        public Website $duplicate
    ) {}
}

// En DuplicateWebsiteService::duplicate()
event(new WebsiteDuplicated($originalWebsite, $newWebsite));

// Listener
namespace App\Listeners;

use App\Events\WebsiteDuplicated;
use Illuminate\Support\Facades\Log;

class LogWebsiteDuplication
{
    public function handle(WebsiteDuplicated $event): void
    {
        Log::info('Website duplicated', [
            'original_id' => $event->original->id,
            'duplicate_id' => $event->duplicate->id,
            'user_id' => $event->original->user_id,
            'timestamp' => now()
        ]);

        // Enviar notificación
        // Actualizar estadísticas
        // etc.
    }
}
```

## Ejemplo 8: API Endpoint para Duplicación

```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\Website;
use App\Services\DuplicateWebsiteService;
use Illuminate\Http\Request;

class WebsiteDuplicateController extends Controller
{
    public function __construct(
        private DuplicateWebsiteService $service
    ) {}

    public function store(Request $request, Website $website)
    {
        // Verificar que es propietario
        if ($website->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|unique:websites,slug'
        ]);

        try {
            $newWebsite = $this->service->duplicate(
                $website,
                $validated['name'],
                $validated['slug'] ?? null
            );

            return response()->json([
                'success' => true,
                'website' => [
                    'id' => $newWebsite->id,
                    'name' => $newWebsite->name,
                    'slug' => $newWebsite->slug,
                    'created_at' => $newWebsite->created_at
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}

// Ruta
Route::post('/api/websites/{website}/duplicate', [WebsiteDuplicateController::class, 'store']);
```

## Ejemplo 9: Middleware para Rate Limiting

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;

class ThrottleDuplicateRequests
{
    public function __construct(private RateLimiter $limiter) {}

    public function handle(Request $request, Closure $next)
    {
        $key = 'duplicate-website:' . auth()->id();

        if ($this->limiter->tooManyAttempts($key, 10)) {
            return response()->json([
                'error' => 'Demasiadas duplicaciones. Intenta en ' .
                    $this->limiter->availableIn($key) . ' segundos'
            ], 429);
        }

        $this->limiter->hit($key, 60); // 1 minuto

        return $next($request);
    }
}

// En kernel.php
protected $routeMiddleware = [
    'throttle.duplicate' => ThrottleDuplicateRequests::class,
];

// En rutas
Route::post('/websites/{website}/duplicate', [...])
    ->middleware('throttle.duplicate');
```

## Ejemplo 10: Job para Duplicación en Background

```php
<?php

namespace App\Jobs;

use App\Models\Website;
use App\Services\DuplicateWebsiteService;
use App\Notifications\WebsiteDuplicatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DuplicateWebsiteJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(
        private Website $website,
        private string $name,
        private ?string $slug = null
    ) {}

    public function handle(DuplicateWebsiteService $service): void
    {
        $newWebsite = $service->duplicate(
            $this->website,
            $this->name,
            $this->slug
        );

        // Notificar al usuario
        $this->website->user->notify(
            new WebsiteDuplicatedNotification($newWebsite)
        );
    }
}

// Uso
DuplicateWebsiteJob::dispatch($website, 'Nueva Copia');
```

## Tips de Debugging

```php
// Ver SQL ejecutado
\DB::listen(function($query) {
    \Log::info($query->sql);
});

// Ver qué se está duplicando
dump($newWebsite->load([
    'pages',
    'blogPosts',
    'menus.items',
    'categories',
    'tags'
]));

// Verificar integridad
$website->pages()->count() === $newWebsite->pages()->count();
$website->blogPosts()->count() === $newWebsite->blogPosts()->count();
```
