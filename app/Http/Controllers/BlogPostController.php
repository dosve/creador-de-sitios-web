<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index(Website $website)
    {
        $this->authorize('view', $website);
        
        $blogPosts = $website->blogPosts()
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(10);

        $categories = $website->categories()->active()->get();
        $tags = $website->tags()->get();

        return view('creator.blog.index', compact('website', 'blogPosts', 'categories', 'tags'));
    }

    public function create(Website $website)
    {
        $this->authorize('update', $website);
        
        $categories = $website->categories()->active()->get();
        $tags = $website->tags()->get();
        
        return view('creator.blog.create', compact('website', 'categories', 'tags'));
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,NULL,id,website_id,' . $website->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $blogPost = $website->blogPosts()->create([
            'title' => $request->title,
            'slug' => $request->slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'featured_image' => $request->featured_image,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
        ]);

        // Asociar tags
        if ($request->tags) {
            $blogPost->tags()->sync($request->tags);
        }

        return redirect()->route('creator.blog.show', [$website, $blogPost])
            ->with('success', 'Artículo creado exitosamente');
    }

    public function show(Website $website, BlogPost $blogPost)
    {
        $this->authorize('view', $website);
        $this->authorize('view', $blogPost);
        
        $blogPost->load(['category', 'tags']);
        
        return view('creator.blog.show', compact('website', 'blogPost'));
    }

    public function edit(Website $website, BlogPost $blogPost)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $blogPost);
        
        $categories = $website->categories()->active()->get();
        $tags = $website->tags()->get();
        $blogPost->load('tags');
        
        return view('creator.blog.edit', compact('website', 'blogPost', 'categories', 'tags'));
    }

    public function update(Request $request, Website $website, BlogPost $blogPost)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $blogPost);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,' . $blogPost->id . ',id,website_id,' . $website->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $blogPost->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'featured_image' => $request->featured_image,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') && !$blogPost->published_at ? now() : $blogPost->published_at,
        ]);

        // Actualizar tags
        if ($request->tags) {
            $blogPost->tags()->sync($request->tags);
        } else {
            $blogPost->tags()->detach();
        }

        return redirect()->route('creator.blog.show', [$website, $blogPost])
            ->with('success', 'Artículo actualizado exitosamente');
    }

    public function destroy(Website $website, BlogPost $blogPost)
    {
        $this->authorize('update', $website);
        $this->authorize('delete', $blogPost);
        
        $blogPost->delete();
        
        return redirect()->route('creator.blog.index', $website)
            ->with('success', 'Artículo eliminado exitosamente');
    }
}
