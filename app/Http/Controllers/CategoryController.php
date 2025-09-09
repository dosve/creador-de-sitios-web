<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Website $website)
    {
        $this->authorize('view', $website);
        
        $categories = $website->categories()->latest()->paginate(10);
        
        return view('creator.categories.index', compact('website', 'categories'));
    }

    public function create(Website $website)
    {
        $this->authorize('update', $website);
        
        return view('creator.categories.create', compact('website'));
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|max:7',
        ]);

        $website->categories()->create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'is_active' => true,
        ]);

        return redirect()->route('creator.categories.index', $website)
            ->with('success', 'Categoría creada exitosamente');
    }

    public function edit(Website $website, Category $category)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $category);
        
        return view('creator.categories.edit', compact('website', 'category'));
    }

    public function update(Request $request, Website $website, Category $category)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $category);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|max:7',
            'is_active' => 'boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('creator.categories.index', $website)
            ->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Website $website, Category $category)
    {
        $this->authorize('update', $website);
        $this->authorize('delete', $category);
        
        // Verificar si hay posts asociados
        if ($category->blogPosts()->count() > 0) {
            return redirect()->route('creator.categories.index', $website)
                ->with('error', 'No se puede eliminar la categoría porque tiene artículos asociados');
        }
        
        $category->delete();
        
        return redirect()->route('creator.categories.index', $website)
            ->with('success', 'Categoría eliminada exitosamente');
    }
}
