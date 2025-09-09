<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\SharedComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SharedComponentController extends Controller
{
    public function index(Website $website)
    {
        $this->authorize('view', $website);
        
        $components = $website->sharedComponents()
            ->ordered()
            ->paginate(15);
        
        $componentTypes = [
            'header' => 'Encabezados',
            'footer' => 'Pies de página',
            'menu' => 'Menús',
            'block' => 'Bloques reutilizables'
        ];
        
        return view('creator.components.index', compact('website', 'components', 'componentTypes'));
    }

    public function create(Website $website)
    {
        $this->authorize('update', $website);
        
        $componentTypes = [
            'header' => 'Encabezado',
            'footer' => 'Pie de página',
            'menu' => 'Menú de navegación',
            'block' => 'Bloque reutilizable'
        ];
        
        return view('creator.components.create', compact('website', 'componentTypes'));
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:header,footer,menu,block',
            'description' => 'nullable|string|max:500',
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'grapesjs_data' => 'nullable|json',
            'settings' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $component = $website->sharedComponents()->create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'html_content' => $request->html_content,
            'css_content' => $request->css_content,
            'grapesjs_data' => $request->grapesjs_data,
            'settings' => $request->settings,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $website->sharedComponents()->max('sort_order') + 1,
        ]);

        return redirect()->route('creator.components.show', [$website, $component])
            ->with('success', 'Componente creado exitosamente');
    }

    public function show(Website $website, SharedComponent $component)
    {
        $this->authorize('view', $website);
        $this->authorize('view', $component);
        
        return view('creator.components.show', compact('website', 'component'));
    }

    public function edit(Website $website, SharedComponent $component)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $component);
        
        $componentTypes = [
            'header' => 'Encabezado',
            'footer' => 'Pie de página',
            'menu' => 'Menú de navegación',
            'block' => 'Bloque reutilizable'
        ];
        
        return view('creator.components.edit', compact('website', 'component', 'componentTypes'));
    }

    public function update(Request $request, Website $website, SharedComponent $component)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $component);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:header,footer,menu,block',
            'description' => 'nullable|string|max:500',
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'grapesjs_data' => 'nullable|json',
            'settings' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $component->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'html_content' => $request->html_content,
            'css_content' => $request->css_content,
            'grapesjs_data' => $request->grapesjs_data,
            'settings' => $request->settings,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('creator.components.show', [$website, $component])
            ->with('success', 'Componente actualizado exitosamente');
    }

    public function destroy(Website $website, SharedComponent $component)
    {
        $this->authorize('update', $website);
        $this->authorize('delete', $component);
        
        $component->delete();
        
        return redirect()->route('creator.components.index', $website)
            ->with('success', 'Componente eliminado exitosamente');
    }

    public function duplicate(Website $website, SharedComponent $component)
    {
        $this->authorize('update', $website);
        $this->authorize('view', $component);
        
        $duplicate = $component->duplicate();
        
        return redirect()->route('creator.components.show', [$website, $duplicate])
            ->with('success', 'Componente duplicado exitosamente');
    }

    public function toggleStatus(Website $website, SharedComponent $component)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $component);
        
        $component->update(['is_active' => !$component->is_active]);
        
        $status = $component->is_active ? 'activado' : 'desactivado';
        return redirect()->route('creator.components.index', $website)
            ->with('success', "Componente {$status} exitosamente");
    }

    public function editor(Website $website, SharedComponent $component)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $component);
        
        return view('creator.components.editor', compact('website', 'component'));
    }

    public function saveContent(Request $request, Website $website, SharedComponent $component)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $component);
        
        $request->validate([
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'grapesjs_data' => 'nullable|json',
        ]);

        $component->update([
            'html_content' => $request->html_content,
            'css_content' => $request->css_content,
            'grapesjs_data' => $request->grapesjs_data,
        ]);

        return response()->json(['success' => true, 'message' => 'Contenido guardado exitosamente']);
    }
}
