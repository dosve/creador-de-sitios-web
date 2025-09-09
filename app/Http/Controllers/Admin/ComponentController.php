<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SharedComponent;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function index()
    {
        $components = SharedComponent::with('website.user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $componentTypes = [
            'header' => 'Encabezados',
            'footer' => 'Pies de página',
            'menu' => 'Menús',
            'block' => 'Bloques reutilizables'
        ];
        
        return view('admin.components.index', compact('components', 'componentTypes'));
    }

    public function show(SharedComponent $component)
    {
        $component->load('website.user');
        return view('admin.components.show', compact('component'));
    }

    public function edit(SharedComponent $component)
    {
        $componentTypes = [
            'header' => 'Encabezado',
            'footer' => 'Pie de página',
            'menu' => 'Menú de navegación',
            'block' => 'Bloque reutilizable'
        ];
        
        return view('admin.components.edit', compact('component', 'componentTypes'));
    }

    public function update(Request $request, SharedComponent $component)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:header,footer,menu,block',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $component->update([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.components.index')
            ->with('success', 'Componente actualizado exitosamente');
    }

    public function destroy(SharedComponent $component)
    {
        $component->delete();
        
        return redirect()->route('admin.components.index')
            ->with('success', 'Componente eliminado exitosamente');
    }

    public function toggleStatus(SharedComponent $component)
    {
        $component->update(['is_active' => !$component->is_active]);
        
        $status = $component->is_active ? 'activado' : 'desactivado';
        return redirect()->route('admin.components.index')
            ->with('success', "Componente {$status} exitosamente");
    }
}
