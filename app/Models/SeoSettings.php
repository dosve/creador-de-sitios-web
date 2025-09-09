<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeoSettings extends Model
{
    use HasFactory;

    protected $table = 'seo_settings';

    protected $fillable = [
        'website_id',
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
        'structured_data',
    ];

    protected function casts(): array
    {
        return [
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'structured_data' => 'array',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    // Métodos de utilidad
    public function getRobotsContentAttribute()
    {
        $robots = [];
        
        if (!$this->robots_index) {
            $robots[] = 'noindex';
        }
        
        if (!$this->robots_follow) {
            $robots[] = 'nofollow';
        }
        
        return empty($robots) ? 'index, follow' : implode(', ', $robots);
    }

    public function getTwitterCardAttribute($value)
    {
        return $value ?: 'summary';
    }

    public function generateStructuredData()
    {
        $website = $this->website;
        
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $website->name,
            'description' => $website->description,
            'url' => $website->getUrl(),
        ];

        if ($website->domain) {
            $structuredData['sameAs'] = [
                'https://' . $website->domain,
            ];
        }

        return $structuredData;
    }

    public function getGoogleAnalyticsScript()
    {
        if (!$this->google_analytics_id) {
            return null;
        }

        return "
        <!-- Google Analytics -->
        <script async src=\"https://www.googletagmanager.com/gtag/js?id={$this->google_analytics_id}\"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{$this->google_analytics_id}');
        </script>";
    }

    public function getGoogleTagManagerScript()
    {
        if (!$this->google_tag_manager_id) {
            return null;
        }

        return "
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{$this->google_tag_manager_id}');</script>";
    }

    public function getFacebookPixelScript()
    {
        if (!$this->facebook_pixel_id) {
            return null;
        }

        return "
        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{$this->facebook_pixel_id}');
        fbq('track', 'PageView');
        </script>
        <noscript><img height=\"1\" width=\"1\" style=\"display:none\"
        src=\"https://www.facebook.com/tr?id={$this->facebook_pixel_id}&ev=PageView&noscript=1\"
        /></noscript>";
    }
}