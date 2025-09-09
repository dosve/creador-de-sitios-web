<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('website.user')
            ->withCount('blogPosts')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_id' => 'required|exists:websites,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
        ]);

        Category::create([
            'website_id' => $request->website_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'color' => $request->color ?: '#3B82F6',
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    public function show(Category $category)
    {
        $category->load(['website.user', 'blogPosts']);
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'color' => $request->color ?: '#3B82F6',
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Category $category)
    {
        // Verificar si tiene artículos asociados
        if ($category->blogPosts()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene artículos asociados');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría eliminada exitosamente');
    }

    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        
        $status = $category->is_active ? 'activada' : 'desactivada';
        return redirect()->route('admin.categories.index')
            ->with('success', "Categoría {$status} exitosamente");
    }
}
