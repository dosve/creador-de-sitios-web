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
    public function index(Website $website)
    {
        $this->authorize('view', $website);

        $menus = $website->menus()->with('items')->get();

        return view('creator.menus.index', compact('website', 'menus'));
    }

    /**
     * Mostrar el formulario para crear un nuevo menú
     */
    public function create(Website $website)
    {
        $this->authorize('update', $website);

        return view('creator.menus.create', compact('website'));
    }

    /**
     * Almacenar un nuevo menú
     */
    public function store(Request $request, Website $website)
    {
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

        return redirect()->route('creator.websites.menus.show', [$website, $menu])
            ->with('success', 'Menú creado exitosamente');
    }

    /**
     * Mostrar un menú específico y sus items
     */
    public function show(Website $website, Menu $menu)
    {
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

        return view('creator.menus.show', compact('website', 'menu', 'pages'));
    }

    /**
     * Mostrar el formulario para editar un menú
     */
    public function edit(Website $website, Menu $menu)
    {
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id) {
            abort(403);
        }

        return view('creator.menus.edit', compact('website', 'menu'));
    }

    /**
     * Actualizar un menú
     */
    public function update(Request $request, Website $website, Menu $menu)
    {
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

        return redirect()->route('creator.websites.menus.show', [$website, $menu])
            ->with('success', 'Menú actualizado exitosamente');
    }

    /**
     * Eliminar un menú
     */
    public function destroy(Website $website, Menu $menu)
    {
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id) {
            abort(403);
        }

        $menu->delete();

        return redirect()->route('creator.websites.menus.index', $website)
            ->with('success', 'Menú eliminado exitosamente');
    }

    /**
     * Crear un nuevo item del menú
     */
    public function storeItem(Request $request, Website $website, Menu $menu)
    {
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
        $data = [
            'title' => $request->title,
            'page_id' => $request->type === 'page' ? $request->page_id : null,
            'url' => $request->type !== 'page' ? $request->url : null,
            'target' => $request->target ?? '_self',
            'icon' => $request->icon,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'order' => ($menu->items()->max('order') ?? 0) + 1,
            'is_active' => true,
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
        return redirect()->route('creator.websites.menus.show', [$website, $menu])
            ->with('success', 'Item del menú creado exitosamente');
    }

    /**
     * Actualizar un item del menú
     */
    public function updateItem(Request $request, Website $website, Menu $menu, MenuItem $menuItem)
    {
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

        $menuItem->update([
            'title' => $request->title,
            'page_id' => $request->type === 'page' ? $request->page_id : null,
            'url' => $request->type !== 'page' ? $request->url : null,
            'target' => $request->target ?? '_self',
            'icon' => $request->icon,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('creator.websites.menus.show', [$website, $menu])
            ->with('success', 'Item del menú actualizado exitosamente');
    }

    /**
     * Eliminar un item del menú
     */
    public function destroyItem(Website $website, Menu $menu, MenuItem $menuItem)
    {
        $this->authorize('update', $website);

        if ($menu->website_id !== $website->id || $menuItem->menu_id !== $menu->id) {
            abort(403);
        }

        $menuItem->delete();

        return redirect()->route('creator.websites.menus.show', [$website, $menu])
            ->with('success', 'Item del menú eliminado exitosamente');
    }

    /**
     * Actualizar el orden de los items del menú
     */
    public function updateOrder(Request $request, Website $website, Menu $menu)
    {
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
}
