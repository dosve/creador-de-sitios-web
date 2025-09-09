<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Website;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Website $website)
    {
        $pages = $website->pages()->latest()->paginate(15);
        return view('admin.pages.index', compact('website', 'pages'));
    }

    public function create(Website $website)
    {
        return view('admin.pages.create', compact('website'));
    }

    public function store(Request $request, Website $website)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,NULL,id,website_id,' . $website->id,
            'meta_description' => 'nullable|string|max:500',
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $page = $website->pages()->create([
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_description' => $request->meta_description,
            'html_content' => $request->html_content,
            'css_content' => $request->css_content,
            'grapesjs_data' => $request->grapesjs_data ? json_decode($request->grapesjs_data, true) : null,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.websites.show', $website)
            ->with('success', 'Página creada exitosamente');
    }

    public function show(Website $website, Page $page)
    {
        return view('admin.pages.show', compact('website', 'page'));
    }

    public function edit(Website $website, Page $page)
    {
        return view('admin.pages.edit', compact('website', 'page'));
    }

    public function update(Request $request, Website $website, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id . ',id,website_id,' . $website->id,
            'meta_description' => 'nullable|string|max:500',
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_description' => $request->meta_description,
            'html_content' => $request->html_content,
            'css_content' => $request->css_content,
            'grapesjs_data' => $request->grapesjs_data ? json_decode($request->grapesjs_data, true) : null,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.websites.show', $website)
            ->with('success', 'Página actualizada exitosamente');
    }

    public function destroy(Website $website, Page $page)
    {
        $page->delete();

        return redirect()->route('admin.websites.show', $website)
            ->with('success', 'Página eliminada exitosamente');
    }

    public function editor(Website $website, Page $page)
    {
        return view('admin.pages.editor-fixed', compact('website', 'page'));
    }

    public function saveEditor(Request $request, Website $website, Page $page)
    {
        $request->validate([
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'grapesjs_data' => 'nullable|string',
        ]);

        $page->update([
            'html_content' => $request->html_content,
            'css_content' => $request->css_content,
            'grapesjs_data' => $request->grapesjs_data ? json_decode($request->grapesjs_data, true) : null,
        ]);

        return response()->json(['success' => true, 'message' => 'Página guardada exitosamente']);
    }
}
