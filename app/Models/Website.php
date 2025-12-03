<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'domain',
        'subdomain',
        'logo',
        'favicon',
        'is_published',
        'settings',
        'seo_settings',
        'template_id',
        'api_key',
        'api_base_url',
        'epayco_public_key',
        'epayco_private_key',
        'epayco_customer_id',
        'allow_cash_on_delivery',
        'allow_online_payment',
        'require_payment_before_shipping',
        'cash_on_delivery_instructions',
        'wompi_public_key',
        'wompi_private_key',
        'wompi_event_key',
        'wompi_integrity_key',
        'default_payment_gateway',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'settings' => 'array',
            'seo_settings' => 'array',
        ];
    }

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    // Nota: template_id ahora guarda el slug de la plantilla (string), no una foreign key
    // Las plantillas se cargan desde archivos usando TemplateService
    
    public function mediaFiles()
    {
        return $this->hasMany(MediaFile::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function sharedComponents()
    {
        return $this->hasMany(SharedComponent::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    // Métodos de utilidad para componentes
    public function getHeaderComponent()
    {
        return $this->sharedComponents()->active()->byType('header')->first();
    }

    public function getFooterComponent()
    {
        return $this->sharedComponents()->active()->byType('footer')->first();
    }

    public function getMenuComponents()
    {
        return $this->sharedComponents()->active()->byType('menu')->ordered()->get();
    }

    public function getBlockComponents()
    {
        return $this->sharedComponents()->active()->byType('block')->ordered()->get();
    }

    public function seoSettings()
    {
        return $this->hasOne(SeoSettings::class);
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Métodos de utilidad para SEO
    public function getUrl()
    {
        // Buscar dominio personalizado verificado
        $customDomain = $this->domains()
            ->where('is_verified', true)
            ->where('status', 'active')
            ->where('is_primary', true)
            ->first();
            
        if ($customDomain) {
            return 'https://' . $customDomain->domain;
        }
        
        // Si tiene subdominio, usar creadorweb.eme10.com
        if ($this->subdomain) {
            return 'https://' . $this->subdomain . '.creadorweb.eme10.com';
        }
        
        return url('/');
    }

    public function getSitemapUrl()
    {
        return $this->getUrl() . '/sitemap.xml';
    }

    public function getRobotsTxtUrl()
    {
        return $this->getUrl() . '/robots.txt';
    }
}
