User-agent: Googlebot
@if($seoSettings && $seoSettings->allow_google_index)
Allow: /
@else
Disallow: /
@endif

User-agent: Bingbot
@if($seoSettings && $seoSettings->allow_bing_index)
Allow: /
@else
Disallow: /
@endif

User-agent: *
@if($seoSettings && $seoSettings->robots_index && $seoSettings->robots_follow)
Allow: /
@elseif($seoSettings && $seoSettings->robots_index && !$seoSettings->robots_follow)
Allow: /
Disallow: /
@elseif($seoSettings && !$seoSettings->robots_index && $seoSettings->robots_follow)
Disallow: /
@else
Disallow: /
@endif

# Rutas que no deben ser indexadas
Disallow: /admin
Disallow: /dashboard
Disallow: /creator
Disallow: /api
Disallow: /login
Disallow: /register
Disallow: /password
Disallow: /account

# Crawl-delay para evitar sobrecarga
Crawl-delay: 1

# Sitemap
@php
    $sitemapUrl = $seoSettings && $seoSettings->sitemap_url 
        ? $seoSettings->sitemap_url 
        : $website->getSitemapUrl() ?? request()->getScheme() . '://' . request()->getHost() . '/websites/' . $website->id . '/seo/sitemap';
@endphp
Sitemap: {{ $sitemapUrl }}

# Host canónico
@if($seoSettings && $seoSettings->canonical_url)
Host: {{ $seoSettings->canonical_url }}
@elseif($website->domain)
Host: {{ $website->domain->domain }}
@endif
