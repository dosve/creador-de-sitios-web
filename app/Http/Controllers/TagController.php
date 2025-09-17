<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index(Website $website)
    {
        $this->authorize('view', $website);

        $tags = $website->tags()->latest()->paginate(10);

        return view('creator.tags.index', compact('website', 'tags'));
    }

    public function create(Website $website)
    {
        $this->authorize('update', $website);

        return view('creator.tags.create', compact('website'));
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|max:7',
        ]);

        $website->tags()->create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('creator.tags.index', $website)
            ->with('success', 'Etiqueta creada exitosamente');
    }

    public function edit(Website $website, Tag $tag)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $tag);

        // TODO: Crear vista creator.tags.edit
        return view('creator.tags.edit', compact('website', 'tag'));
    }

    public function update(Request $request, Website $website, Tag $tag)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $tag);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|max:7',
        ]);

        $tag->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('creator.tags.index', $website)
            ->with('success', 'Etiqueta actualizada exitosamente');
    }

    public function destroy(Website $website, Tag $tag)
    {
        $this->authorize('update', $website);
        $this->authorize('delete', $tag);

        $tag->delete();

        return redirect()->route('creator.tags.index', $website)
            ->with('success', 'Etiqueta eliminada exitosamente');
    }
}
