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
    public function index(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        $blogPosts = $website->blogPosts()->with(['category', 'tags'])->latest()->get();
        
        return view('creator.blog.index', compact('website', 'blogPosts'));
    }

    public function create(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $categories = $website->categories()->get();
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
            'is_published' => 'boolean',
        ]);

        $blogPost = $website->blogPosts()->create([
            'title' => $request->title,
            'slug' => $request->slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_published' => $request->boolean('is_published', false),
        ]);

        // Attach tags
        if ($request->tags) {
            $blogPost->tags()->sync($request->tags);
        }

        return redirect()->route('creator.blog.index', $website)
            ->with('success', 'Artículo creado exitosamente');
    }

    public function show(Request $request, Website $website, BlogPost $blogPost)
    {
        $this->authorize('view', $website);
        
        return view('creator.blog.show', compact('website', 'blogPost'));
    }

    public function edit(Request $request, Website $website, BlogPost $blogPost)
    {
        $this->authorize('update', $website);
        
        $categories = $website->categories()->get();
        $tags = $website->tags()->get();
        
        return view('creator.blog.edit', compact('website', 'blogPost', 'categories', 'tags'));
    }

    public function update(Request $request, Website $website, BlogPost $blogPost)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug,' . $blogPost->id . ',id,website_id,' . $website->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
        ]);

        $blogPost->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_published' => $request->boolean('is_published', false),
        ]);

        // Update tags
        if ($request->tags) {
            $blogPost->tags()->sync($request->tags);
        } else {
            $blogPost->tags()->detach();
        }

        return redirect()->route('creator.blog.index', $website)
            ->with('success', 'Artículo actualizado exitosamente');
    }

    public function destroy(Request $request, Website $website, BlogPost $blogPost)
    {
        $this->authorize('update', $website);
        
        $blogPost->delete();

        return redirect()->route('creator.blog.index', $website)
            ->with('success', 'Artículo eliminado exitosamente');
    }
}
