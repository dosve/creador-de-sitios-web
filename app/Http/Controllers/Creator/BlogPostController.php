<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogPostController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);
        
        $blogPosts = $website->blogPosts()->with(['category', 'tags'])->latest()->get();
        
        return view('creator.blog.index', compact('blogPosts', 'website'));
    }

    public function create(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);
        
        $categories = $website->categories()->get();
        $tags = $website->tags()->get();
        
        return view('creator.blog.create', compact('categories', 'tags', 'website'));
    }

    public function store(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,NULL,id,website_id,' . $website->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'featured_image' => 'nullable|url',
            'is_published' => 'boolean',
        ]);

        $blogPost = $website->blogPosts()->create([
            'title' => $request->title,
            'slug' => $request->slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'featured_image' => $request->featured_image,
            'is_published' => $request->boolean('is_published', false),
        ]);

        // Attach tags
        if ($request->tags) {
            $blogPost->tags()->sync($request->tags);
        }

        return redirect()->route('creator.blog.index')
            ->with('success', 'Artículo creado exitosamente');
    }

    public function show(Request $request, BlogPost $blogPost)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);
        
        return view('creator.blog.show', compact('blogPost', 'website'));
    }

    public function edit(Request $request, BlogPost $blogPost)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);
        
        $categories = $website->categories()->get();
        $tags = $website->tags()->get();
        
        return view('creator.blog.edit', compact('blogPost', 'categories', 'tags', 'website'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,' . $blogPost->id . ',id,website_id,' . $website->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'featured_image' => 'nullable|url',
            'is_published' => 'boolean',
        ]);

        $blogPost->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'featured_image' => $request->featured_image,
            'is_published' => $request->boolean('is_published', false),
        ]);

        // Update tags
        if ($request->tags) {
            $blogPost->tags()->sync($request->tags);
        } else {
            $blogPost->tags()->detach();
        }

        return redirect()->route('creator.blog.index')
            ->with('success', 'Artículo actualizado exitosamente');
    }

    public function destroy(Request $request, BlogPost $blogPost)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);
        
        $blogPost->delete();

        return redirect()->route('creator.blog.index')
            ->with('success', 'Artículo eliminado exitosamente');
    }

    /**
     * API para obtener posts del blog (para el componente dinámico)
     */
    public function apiIndex(Request $request, Website $website)
    {
        // Solo verificar autorización básica, no restringir por usuario en API
        // $this->authorize('view', $website);
        
        $perPage = $request->get('per_page', 6);
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        
        $query = $website->blogPosts()
            ->where('is_published', true)
            ->with(['category', 'tags']);
        
        // Aplicar búsqueda si existe
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        // Aplicar ordenamiento
        $query->orderBy($sort, $order);
        
        $blogPosts = $query->paginate($perPage, ['*'], 'page', $page);
        
        return response()->json([
            'data' => $blogPosts->items(),
            'current_page' => $blogPosts->currentPage(),
            'last_page' => $blogPosts->lastPage(),
            'per_page' => $blogPosts->perPage(),
            'total' => $blogPosts->total(),
            'has_more_pages' => $blogPosts->hasMorePages()
        ]);
    }

    /**
     * Mostrar índice público de posts del blog
     */
    public function publicIndex(Website $website)
    {
        $blogPosts = $website->blogPosts()
            ->where('is_published', true)
            ->with(['category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('public.blog.index', compact('website', 'blogPosts'));
    }

    /**
     * Mostrar post público del blog
     */
    public function publicShow(Website $website, BlogPost $blogPost)
    {
        // Verificar que el post pertenece al sitio web y está publicado
        if ($blogPost->website_id !== $website->id || !$blogPost->is_published) {
            abort(404);
        }

        $blogPost->load(['category', 'tags']);

        // Obtener posts relacionados
        $relatedPosts = $website->blogPosts()
            ->where('is_published', true)
            ->where('id', '!=', $blogPost->id)
            ->where(function($query) use ($blogPost) {
                $query->where('category_id', $blogPost->category_id)
                      ->orWhereHas('tags', function($q) use ($blogPost) {
                          $q->whereIn('tags.id', $blogPost->tags->pluck('id'));
                      });
            })
            ->with(['category', 'tags'])
            ->limit(3)
            ->get();

        return view('public.blog.show', compact('website', 'blogPost', 'relatedPosts'));
    }

    /**
     * Mostrar índice público de posts del blog por dominio personalizado
     */
    public function publicIndexByDomain()
    {
        $host = request()->getHost();
        
        // Buscar el sitio por dominio personalizado
        $domain = \App\Models\Domain::where('domain', $host)
            ->where('is_verified', true)
            ->where('status', 'active')
            ->first();
        
        if (!$domain || !$domain->website) {
            abort(404);
        }
        
        $website = $domain->website;
        
        $blogPosts = $website->blogPosts()
            ->where('is_published', true)
            ->with(['category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('public.blog.index', compact('website', 'blogPosts'));
    }

    /**
     * Mostrar post público del blog por dominio personalizado
     */
    public function publicShowByDomain(BlogPost $blogPost)
    {
        $host = request()->getHost();
        
        // Buscar el sitio por dominio personalizado
        $domain = \App\Models\Domain::where('domain', $host)
            ->where('is_verified', true)
            ->where('status', 'active')
            ->first();
        
        if (!$domain || !$domain->website) {
            abort(404);
        }
        
        $website = $domain->website;
        
        // Verificar que el post pertenece al sitio web y está publicado
        if ($blogPost->website_id !== $website->id || !$blogPost->is_published) {
            abort(404);
        }

        $blogPost->load(['category', 'tags']);

        // Obtener posts relacionados
        $relatedPosts = $website->blogPosts()
            ->where('is_published', true)
            ->where('id', '!=', $blogPost->id)
            ->where(function($query) use ($blogPost) {
                $query->where('category_id', $blogPost->category_id)
                      ->orWhereHas('tags', function($q) use ($blogPost) {
                          $q->whereIn('tags.id', $blogPost->tags->pluck('id'));
                      });
            })
            ->with(['category', 'tags'])
            ->limit(3)
            ->get();

        return view('public.blog.show', compact('website', 'blogPost', 'relatedPosts'));
    }
}
