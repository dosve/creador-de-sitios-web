<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PageController extends Controller
{
    use AuthorizesRequests;
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

        // Verificar que la página pertenece al sitio web
        if ($page->website_id !== $website->id) {
            abort(403);
        }

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
            'is_home' => 'boolean',
        ]);

        // Si esta página se marca como inicio, desmarcar las otras
        if ($request->boolean('is_home', false)) {
            $website->pages()->where('id', '!=', $page->id)->update(['is_home' => false]);
        }

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'html_content' => $request->html_content,
            'is_published' => $request->boolean('is_published', false),
            'is_home' => $request->boolean('is_home', false),
        ]);

        // Si es una petición AJAX/JSON, devolver respuesta JSON
        if ($request->expectsJson() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Página actualizada exitosamente'
            ]);
        }

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

    /**
     * Establecer una página como página de inicio
     */
    public function setHome(Request $request, Website $website, Page $page)
    {
        $this->authorize('update', $website);

        // Verificar que la página pertenece al sitio web
        if ($page->website_id !== $website->id) {
            abort(403);
        }

        // Desmarcar todas las otras páginas como inicio
        $website->pages()->where('id', '!=', $page->id)->update(['is_home' => false]);

        // Marcar esta página como inicio
        $page->update(['is_home' => true]);

        return redirect()->route('creator.pages.index', $website)
            ->with('success', "La página '{$page->title}' ahora es la página de inicio");
    }
}
