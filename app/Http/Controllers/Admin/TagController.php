<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::with('website.user')
            ->withCount('blogPosts')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_id' => 'required|exists:websites,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
        ]);

        Tag::create([
            'website_id' => $request->website_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'color' => $request->color ?: '#10B981',
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Etiqueta creada exitosamente');
    }

    public function show(Tag $tag)
    {
        $tag->load(['website.user', 'blogPosts']);
        return view('admin.tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:7',
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'color' => $request->color ?: '#10B981',
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Etiqueta actualizada exitosamente');
    }

    public function destroy(Tag $tag)
    {
        // Verificar si tiene artículos asociados
        if ($tag->blogPosts()->count() > 0) {
            return redirect()->route('admin.tags.index')
                ->with('error', 'No se puede eliminar la etiqueta porque tiene artículos asociados');
        }

        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Etiqueta eliminada exitosamente');
    }

    public function toggleStatus(Tag $tag)
    {
        $tag->update(['is_active' => !$tag->is_active]);
        
        $status = $tag->is_active ? 'activada' : 'desactivada';
        return redirect()->route('admin.tags.index')
            ->with('success', "Etiqueta {$status} exitosamente");
    }
}
