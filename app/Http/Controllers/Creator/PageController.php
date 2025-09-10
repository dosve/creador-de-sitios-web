<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        $pages = $website->pages()->latest()->get();
        
        return view('creator.pages.index', compact('website', 'pages'));
    }

    public function create(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        return view('creator.pages.create', compact('website'));
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,NULL,id,website_id,' . $website->id,
            'html_content' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $page = $website->pages()->create([
            'title' => $request->title,
            'slug' => $request->slug,
            'html_content' => $request->html_content ?: '<h1>' . $request->title . '</h1><p>Contenido de la página...</p>',
            'is_published' => $request->boolean('is_published', false),
            'sort_order' => $website->pages()->max('sort_order') + 1,
        ]);

        return redirect()->route('creator.pages.index', $website)
            ->with('success', 'Página creada exitosamente');
    }

    public function show(Request $request, Website $website, Page $page)
    {
        $this->authorize('view', $website);
        
        return view('creator.pages.show', compact('website', 'page'));
    }

    public function edit(Request $request, Website $website, Page $page)
    {
        $this->authorize('update', $website);
        
        return view('creator.pages.edit', compact('website', 'page'));
    }

    public function update(Request $request, Website $website, Page $page)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id . ',id,website_id,' . $website->id,
            'html_content' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'html_content' => $request->html_content,
            'is_published' => $request->boolean('is_published', false),
        ]);

        return redirect()->route('creator.pages.index', $website)
            ->with('success', 'Página actualizada exitosamente');
    }

    public function destroy(Request $request, Website $website, Page $page)
    {
        $this->authorize('update', $website);
        
        $page->delete();

        return redirect()->route('creator.pages.index', $website)
            ->with('success', 'Página eliminada exitosamente');
    }
}