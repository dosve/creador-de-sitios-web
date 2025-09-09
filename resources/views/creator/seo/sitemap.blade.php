<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Página principal -->
    <url>
        <loc>{{ $website->getUrl() }}</loc>
        <lastmod>{{ $website->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Páginas del sitio -->
    @foreach($pages as $page)
        <url>
            <loc>{{ $website->getUrl() }}/{{ $page->slug }}</loc>
            <lastmod>{{ $page->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <!-- Página del blog -->
    <url>
        <loc>{{ $website->getUrl() }}/blog</loc>
        <lastmod>{{ $blogPosts->max('updated_at') ? $blogPosts->max('updated_at')->format('Y-m-d') : $website->updated_at->format('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Artículos del blog -->
    @foreach($blogPosts as $post)
        <url>
            <loc>{{ $website->getUrl() }}/blog/{{ $post->slug }}</loc>
            <lastmod>{{ $post->updated_at->format('Y-m-d') }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>
