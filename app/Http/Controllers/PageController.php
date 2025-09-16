<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Page;
use App\Models\PageVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PageController extends Controller
{
    use AuthorizesRequests;
    public function index(Website $website)
    {
        $this->authorize('view', $website);
        $pages = $website->pages()->orderBy('sort_order')->get();
        return view('creator.pages.index', compact('website', 'pages'));
    }

    public function create(Website $website)
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
            'meta_description' => 'nullable|string|max:160',
            'html_content' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $page = $website->pages()->create([
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_description' => $request->meta_description,
            'html_content' => $request->html_content ?: '<h1>' . $request->title . '</h1><p>Contenido de la página...</p>',
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $website->pages()->max('sort_order') + 1,
        ]);

        // Crear versión inicial
        $page->createVersion('Página creada');

        return redirect()->route('creator.pages.show', [$website, $page])
            ->with('success', 'Página creada exitosamente');
    }

    public function show(Website $website, Page $page)
    {
        $this->authorize('view', $website);
        $this->authorize('view', $page);
        return view('creator.pages.show', compact('website', 'page'));
    }

    public function edit(Website $website, Page $page)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $page);
        return view('creator.pages.edit', compact('website', 'page'));
    }

    public function update(Request $request, Website $website, Page $page)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $page);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id . ',id,website_id,' . $website->id,
            'meta_description' => 'nullable|string|max:160',
            'html_content' => 'nullable|string',
            'is_published' => 'boolean',
            'change_description' => 'nullable|string|max:255',
        ]);

        // Crear versión antes de actualizar
        $page->createVersion($request->change_description ?: 'Página actualizada');

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'meta_description' => $request->meta_description,
            'html_content' => $request->html_content,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('creator.pages.show', [$website, $page])
            ->with('success', 'Página actualizada exitosamente');
    }

    public function destroy(Website $website, Page $page)
    {
        $this->authorize('update', $website);
        $this->authorize('delete', $page);

        $page->delete();

        return redirect()->route('creator.pages.index', $website)
            ->with('success', 'Página eliminada exitosamente');
    }

    public function editor(Website $website, Page $page)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $page);

        return view('creator.pages.editor', [
            'website' => $website,
            'editable' => $page,
            'editableType' => 'page',
            'saveRoute' => route('creator.pages.save', [$website, $page])
        ]);
    }

    public function saveContent(Request $request, Website $website, Page $page)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $page);

        $request->validate([
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'grapesjs_data' => 'nullable|json',
        ]);

        $page->update([
            'html_content' => $request->html_content,
            'css_content' => $request->css_content,
            'grapesjs_data' => $request->grapesjs_data,
        ]);

        return response()->json(['success' => true, 'message' => 'Contenido guardado exitosamente']);
    }

    public function versions(Website $website, Page $page)
    {
        $this->authorize('view', $website);
        $this->authorize('view', $page);

        $versions = $page->versions()->with('user')->paginate(10);

        return view('creator.pages.versions', compact('website', 'page', 'versions'));
    }

    public function showVersion(Website $website, Page $page, PageVersion $version)
    {
        $this->authorize('view', $website);
        $this->authorize('view', $page);

        return view('creator.pages.version-show', compact('website', 'page', 'version'));
    }

    public function restoreVersion(Request $request, Website $website, Page $page, PageVersion $version)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $page);

        $request->validate([
            'change_description' => 'nullable|string|max:255',
        ]);

        $page->restoreFromVersion($version);

        return redirect()->route('creator.pages.show', [$website, $page])
            ->with('success', "Página restaurada desde la versión {$version->version_number}");
    }

    public function compareVersions(Website $website, Page $page, PageVersion $version1, PageVersion $version2)
    {
        $this->authorize('view', $website);
        $this->authorize('view', $page);

        return view('creator.pages.compare-versions', compact('website', 'page', 'version1', 'version2'));
    }
}
