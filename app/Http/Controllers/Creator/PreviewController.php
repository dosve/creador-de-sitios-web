<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Page;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PreviewController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar vista previa del sitio web
     */
    public function index(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        // Obtener páginas del sitio web
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();
        
        // Obtener posts del blog
        $blogPosts = $website->blogPosts()->where('is_published', true)->latest()->take(5)->get();
        
        // Obtener la página de inicio
        $homePage = $pages->where('is_home', true)->first();
        
        return view('creator.preview.index', compact('website', 'pages', 'blogPosts', 'homePage'));
    }

    /**
     * Mostrar vista previa de una página específica
     */
    public function page(Request $request, Website $website, Page $page)
    {
        $this->authorize('view', $website);
        
        // Verificar que la página pertenece al sitio web
        if ($page->website_id !== $website->id) {
            abort(403);
        }
        
        // Obtener páginas para el menú de navegación
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();
        
        return view('creator.preview.page', compact('website', 'page', 'pages'));
    }

    /**
     * Mostrar vista previa de un post del blog
     */
    public function blogPost(Request $request, Website $website, BlogPost $blogPost)
    {
        $this->authorize('view', $website);
        
        // Verificar que el post pertenece al sitio web
        if ($blogPost->website_id !== $website->id) {
            abort(403);
        }
        
        // Obtener páginas para el menú de navegación
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();
        
        // Obtener posts relacionados
        $relatedPosts = $website->blogPosts()
            ->where('is_published', true)
            ->where('id', '!=', $blogPost->id)
            ->where('category_id', $blogPost->category_id)
            ->latest()
            ->take(3)
            ->get();
        
        return view('creator.preview.blog-post', compact('website', 'blogPost', 'pages', 'relatedPosts'));
    }

    /**
     * Mostrar vista previa del blog
     */
    public function blog(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        // Obtener páginas para el menú de navegación
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();
        
        // Obtener posts del blog con paginación
        $blogPosts = $website->blogPosts()
            ->where('is_published', true)
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(6);
        
        // Obtener categorías
        $categories = $website->categories()->where('is_active', true)->get();
        
        return view('creator.preview.blog', compact('website', 'pages', 'blogPosts', 'categories'));
    }

    /**
     * Mostrar vista previa de contacto
     */
    public function contact(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        // Obtener páginas para el menú de navegación
        $pages = $website->pages()->where('is_published', true)->orderBy('sort_order')->get();
        
        // Obtener formularios de contacto
        $contactForms = $website->forms()
            ->where('type', 'contact')
            ->where('is_active', true)
            ->get();
        
        return view('creator.preview.contact', compact('website', 'pages', 'contactForms'));
    }
}