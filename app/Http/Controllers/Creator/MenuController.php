<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Website;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MenuController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // El middleware 'auth' ya se aplica en las rutas
    }

    /**
     * Mostrar la lista de menús del sitio web
     */
    public function index()
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        // DEBUG: Verificar datos de autorización
        \Log::info('MenuController::index - Verificación de autorización', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'website_id' => $website->id,
            'website_user_id' => $website->user_id,
            'can_view' => auth()->user()->id === $website->user_id || auth()->user()->isAdmin(),
        ]);
        
        $this->authorize('view', $website);

        $menus = $website->menus()->with('items')->get();

        return view('creator.menus.index', compact('menus', 'website'));
    }

    /**
     * Mostrar el formulario para crear un nuevo menú
     */
    public function create()
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        return view('creator.menus.create', compact('website'));
    }

    /**
     * Almacenar un nuevo menú
     */
    public function store(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|in:header,footer,sidebar',
            'description' => 'nullable|string',
        ]);

        $menu = $website->menus()->create([
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('creator.menus.show', $menu)
            ->with('success', 'Menú creado exitosamente');
    }

    /**
     * Mostrar un menú específico y sus items
     */
    public function show(Menu $menu)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);

        if ($menu->website_id !== $website->id) {
            abort(403);
        }

        $menu->load(['items' => function ($query) {
            $query->whereNull('parent_id')->orderBy('order');
        }, 'items.children' => function ($query) {
            $query->orderBy('order');
        }]);

        $pages = $website->pages()->where('is_published', true)->get();

        return view('creator.menus.show', compact('menu', 'pages', 'website'));
    }

    /**
     * Mostrar el formulario para editar un menú
     */
    public function edit(Menu $menu)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id) {
            abort(403);
        }

        return view('creator.menus.edit', compact('menu', 'website'));
    }

    /**
     * Actualizar un menú
     */
    public function update(Request $request, Menu $menu)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|in:header,footer,sidebar',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $menu->update([
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('creator.menus.show', $menu)
            ->with('success', 'Menú actualizado exitosamente');
    }

    /**
     * Eliminar un menú
     */
    public function destroy(Menu $menu)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id) {
            abort(403);
        }

        $menu->delete();

        return redirect()->route('creator.menus.index')
            ->with('success', 'Menú eliminado exitosamente');
    }

    /**
     * Crear un nuevo item del menú
     */
    public function storeItem(Request $request, Menu $menu)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        \Log::info('=== INICIO storeItem ===');
        \Log::info('Datos recibidos:', $request->all());
        \Log::info('Website ID:', ['id' => $website->id]);
        \Log::info('Menu ID:', ['id' => $menu->id]);
        
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id) {
            \Log::error('Menu no pertenece al website');
            abort(403);
        }

        \Log::info('Iniciando validación...');
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'type' => 'required|in:page,custom,external',
                'page_id' => 'required_if:type,page|nullable|exists:pages,id',
                'url' => 'required_if:type,custom|required_if:type,external|nullable|string|max:500',
                'target' => 'in:_self,_blank',
                'icon' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'parent_id' => 'nullable|exists:menu_items,id',
            ]);
            \Log::info('Validación exitosa');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación:', $e->errors());
            throw $e;
        }

        // Verificar que la página pertenece al sitio web
        if ($request->type === 'page' && $request->page_id) {
            $page = Page::find($request->page_id);
            if (!$page || $page->website_id !== $website->id) {
                return back()->withErrors(['page_id' => 'La página seleccionada no pertenece a este sitio web.']);
            }
        }

        // Verificar que el item padre pertenece al mismo menú
        if ($request->parent_id) {
            $parentItem = MenuItem::find($request->parent_id);
            if (!$parentItem || $parentItem->menu_id !== $menu->id) {
                return back()->withErrors(['parent_id' => 'El item padre no pertenece a este menú.']);
            }
        }

        \Log::info('Preparando datos para crear menu item...');
        
        // Determinar automáticamente el target si no se especificó
        $target = $request->target;
        if (!$target) {
            $target = $this->determineTarget($request->type, $request->url);
        }
        
        $data = [
            'title' => $request->title,
            'page_id' => $request->type === 'page' ? $request->page_id : null,
            'url' => $request->type !== 'page' ? $request->url : null,
            'target' => $target,
            'icon' => $request->icon,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'order' => ($menu->items()->max('order') ?? 0) + 1,
            'is_active' => $request->boolean('is_active', true),
        ];
        \Log::info('Datos a insertar:', $data);
        
        try {
            $menuItem = $menu->items()->create($data);
            \Log::info('Menu item creado exitosamente:', ['id' => $menuItem->id]);
        } catch (\Exception $e) {
            \Log::error('Error al crear menu item:', ['error' => $e->getMessage()]);
            throw $e;
        }

        \Log::info('=== FIN storeItem ===');
        return redirect()->route('creator.menus.show', $menu)
            ->with('success', 'Item del menú creado exitosamente');
    }

    /**
     * Actualizar un item del menú
     */
    public function updateItem(Request $request, Menu $menu, MenuItem $menuItem)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id || $menuItem->menu_id !== $menu->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:page,custom,external',
            'page_id' => 'required_if:type,page|nullable|exists:pages,id',
            'url' => 'required_if:type,custom|required_if:type,external|nullable|string|max:500',
            'target' => 'in:_self,_blank',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Verificar que la página pertenece al sitio web
        if ($request->type === 'page' && $request->page_id) {
            $page = Page::find($request->page_id);
            if (!$page || $page->website_id !== $website->id) {
                return back()->withErrors(['page_id' => 'La página seleccionada no pertenece a este sitio web.']);
            }
        }

        // Determinar automáticamente el target si no se especificó
        $target = $request->target;
        if (!$target) {
            $target = $this->determineTarget($request->type, $request->url);
        }
        
        $menuItem->update([
            'title' => $request->title,
            'page_id' => $request->type === 'page' ? $request->page_id : null,
            'url' => $request->type !== 'page' ? $request->url : null,
            'target' => $target,
            'icon' => $request->icon,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('creator.menus.show', $menu)
            ->with('success', 'Item del menú actualizado exitosamente');
    }

    /**
     * Eliminar un item del menú
     */
    public function destroyItem(Menu $menu, MenuItem $menuItem)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id || $menuItem->menu_id !== $menu->id) {
            abort(403);
        }

        $menuItem->delete();

        return redirect()->route('creator.menus.show', $menu)
            ->with('success', 'Item del menú eliminado exitosamente');
    }

    /**
     * Actualizar el orden de los items del menú
     */
    public function updateOrder(Request $request, Menu $menu)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return response()->json(['success' => false, 'message' => 'No website selected'], 403);
        }
        
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id) {
            abort(403);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.order' => 'required|integer|min:0',
            'items.*.parent_id' => 'nullable|exists:menu_items,id',
        ]);

        foreach ($request->items as $item) {
            $menuItem = MenuItem::find($item['id']);
            if ($menuItem && $menuItem->menu_id === $menu->id) {
                $menuItem->update([
                    'order' => $item['order'],
                    'parent_id' => $item['parent_id'] ?? null,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Determinar automáticamente si un enlace debe abrirse en una nueva pestaña
     * 
     * @param string $type Tipo de enlace (page, custom, external)
     * @param string|null $url URL del enlace
     * @return string '_self' o '_blank'
     */
    private function determineTarget($type, $url)
    {
        // Si es una página interna, siempre abrir en la misma pestaña
        if ($type === 'page') {
            return '_self';
        }

        // Si no hay URL, abrir en la misma pestaña
        if (!$url) {
            return '_self';
        }

        // Normalizar la URL
        $url = strtolower(trim($url));

        // Enlaces de correo o teléfono - misma pestaña
        if (str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:')) {
            return '_self';
        }

        // Enlaces con anclas (#) - misma pestaña
        if (str_starts_with($url, '#')) {
            return '_self';
        }

        // Enlaces relativos (comienzan con /) - misma pestaña
        if (str_starts_with($url, '/')) {
            return '_self';
        }

        // Enlaces externos (contienen http:// o https://)
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            // Obtener el dominio actual
            $currentHost = parse_url(config('app.url'), PHP_URL_HOST);
            
            // Obtener el dominio del enlace
            $linkHost = parse_url($url, PHP_URL_HOST);
            
            // Si el dominio es diferente, abrir en nueva pestaña
            if ($linkHost && $linkHost !== $currentHost) {
                return '_blank';
            }
            
            // Si es el mismo dominio, abrir en la misma pestaña
            return '_self';
        }

        // Archivos descargables comunes - nueva pestaña
        $downloadableExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'jpg', 'jpeg', 'png', 'gif'];
        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        
        if (in_array(strtolower($extension), $downloadableExtensions)) {
            return '_blank';
        }

        // Por defecto, enlaces personalizados en la misma pestaña
        return '_self';
    }
}
