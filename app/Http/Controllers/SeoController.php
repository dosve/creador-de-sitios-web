<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\SeoSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeoController extends Controller
{
    public function index(Website $website)
    {
        $this->authorize('view', $website);
        
        $seoSettings = $website->seoSettings;
        
        return view('creator.seo.index', compact('website', 'seoSettings'));
    }

    public function edit(Website $website)
    {
        $this->authorize('update', $website);
        
        $seoSettings = $website->seoSettings;
        
        return view('creator.seo.edit', compact('website', 'seoSettings'));
    }

    public function update(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|url',
            'twitter_card' => 'required|in:summary,summary_large_image,app,player',
            'twitter_site' => 'nullable|string|max:50',
            'twitter_creator' => 'nullable|string|max:50',
            'google_analytics_id' => 'nullable|string|max:20',
            'google_tag_manager_id' => 'nullable|string|max:20',
            'facebook_pixel_id' => 'nullable|string|max:20',
            'custom_head_code' => 'nullable|string',
            'custom_body_code' => 'nullable|string',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'canonical_url' => 'nullable|url',
        ]);

        $seoSettings = $website->seoSettings()->updateOrCreate(
            ['website_id' => $website->id],
            $request->only([
                'meta_title',
                'meta_description',
                'meta_keywords',
                'og_title',
                'og_description',
                'og_image',
                'twitter_card',
                'twitter_site',
                'twitter_creator',
                'google_analytics_id',
                'google_tag_manager_id',
                'facebook_pixel_id',
                'custom_head_code',
                'custom_body_code',
                'robots_index',
                'robots_follow',
                'canonical_url',
            ])
        );

        return redirect()->route('creator.seo.index', $website)
            ->with('success', 'Configuración SEO actualizada exitosamente');
    }

    public function sitemap(Website $website)
    {
        $this->authorize('view', $website);
        
        $pages = $website->pages()->where('is_published', true)->get();
        $blogPosts = $website->blogPosts()->where('is_published', true)->get();
        
        $sitemap = view('creator.seo.sitemap', compact('website', 'pages', 'blogPosts'))
            ->render();
        
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    public function robots(Website $website)
    {
        $this->authorize('view', $website);
        
        $seoSettings = $website->seoSettings;
        
        $robots = view('creator.seo.robots', compact('website', 'seoSettings'))
            ->render();
        
        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function generateSitemap(Website $website)
    {
        $this->authorize('update', $website);
        
        // Esta función podría generar un archivo sitemap.xml físico
        // Por ahora solo redirigimos a la vista del sitemap
        
        return redirect()->route('creator.seo.sitemap', $website)
            ->with('success', 'Sitemap generado exitosamente');
    }

    public function preview(Website $website, $page = null)
    {
        $this->authorize('view', $website);
        
        $seoSettings = $website->seoSettings;
        $currentPage = null;
        
        if ($page) {
            $currentPage = $website->pages()->where('slug', $page)->first();
        }
        
        return view('creator.seo.preview', compact('website', 'seoSettings', 'currentPage'));
    }
}