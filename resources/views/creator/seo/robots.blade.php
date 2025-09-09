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

Sitemap: {{ $website->getSitemapUrl() }}

@if($seoSettings && $seoSettings->canonical_url)
Host: {{ $seoSettings->canonical_url }}
@endif
