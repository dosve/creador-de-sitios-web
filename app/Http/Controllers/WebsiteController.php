<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Auth::user()->websites()->latest()->get();
        return view('creator.websites.index', compact('websites'));
    }

    public function create()
    {
        return view('creator.websites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $website = Auth::user()->websites()->create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'is_published' => false,
        ]);

        // Crear página de inicio automáticamente
        $website->pages()->create([
            'title' => 'Inicio',
            'slug' => 'inicio',
            'html_content' => '<h1>Bienvenido a ' . $website->name . '</h1><p>Esta es tu página de inicio. ¡Comienza a editarla!</p>',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        return redirect()->route('creator.websites.show', $website)
            ->with('success', 'Sitio web creado exitosamente');
    }

    public function show(Website $website)
    {
        $this->authorize('view', $website);
        $pages = $website->pages()->orderBy('sort_order')->get();
        return view('creator.websites.show', compact('website', 'pages'));
    }

    public function edit(Website $website)
    {
        $this->authorize('update', $website);
        return view('creator.websites.edit', compact('website'));
    }

    public function update(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $website->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('creator.websites.show', $website)
            ->with('success', 'Sitio web actualizado exitosamente');
    }

    public function destroy(Website $website)
    {
        $this->authorize('delete', $website);
        $website->delete();
        
        return redirect()->route('creator.websites.index')
            ->with('success', 'Sitio web eliminado exitosamente');
    }
}
