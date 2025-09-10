<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'blog_post_id',
        'name',
        'slug',
        'description',
        'type',
        'settings',
        'email_settings',
        'is_active',
        'show_title',
        'show_description',
        'submit_button_text',
        'success_message',
        'error_message',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'email_settings' => 'array',
            'is_active' => 'boolean',
            'show_title' => 'boolean',
            'show_description' => 'boolean',
        ];
    }

    // Relaciones
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('sort_order');
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForBlog($query)
    {
        return $query->whereNotNull('blog_post_id');
    }

    public function scopeGeneral($query)
    {
        return $query->whereNull('blog_post_id');
    }

    // Métodos de utilidad
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'general' => 'General',
            'contact' => 'Contacto',
            'newsletter' => 'Newsletter',
            'comment' => 'Comentarios',
            'survey' => 'Encuesta',
            'custom' => 'Personalizado',
            default => ucfirst($this->type)
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'general' => 'document-text',
            'contact' => 'mail',
            'newsletter' => 'newspaper',
            'comment' => 'chat-bubble-left-right',
            'survey' => 'clipboard-document-list',
            'custom' => 'cog-6-tooth',
            default => 'document'
        };
    }

    public function getSubmissionsCountAttribute()
    {
        return $this->submissions()->count();
    }

    public function getUnreadSubmissionsCountAttribute()
    {
        return $this->submissions()->where('is_read', false)->count();
    }

    // Métodos para el constructor de formularios
    public function addField($fieldData)
    {
        return $this->fields()->create($fieldData);
    }

    public function reorderFields($fieldIds)
    {
        foreach ($fieldIds as $index => $fieldId) {
            $this->fields()->where('id', $fieldId)->update(['sort_order' => $index + 1]);
        }
    }

    // Métodos para validación
    public function getValidationRules()
    {
        $rules = [];
        
        foreach ($this->fields as $field) {
            $fieldRules = [];
            
            if ($field->is_required) {
                $fieldRules[] = 'required';
            }
            
            // Agregar reglas específicas del tipo de campo
            switch ($field->type) {
                case 'email':
                    $fieldRules[] = 'email';
                    break;
                case 'url':
                    $fieldRules[] = 'url';
                    break;
                case 'number':
                    $fieldRules[] = 'numeric';
                    break;
                case 'file':
                    $fieldRules[] = 'file';
                    break;
            }
            
            // Agregar reglas personalizadas si existen
            if ($field->validation_rules) {
                $fieldRules = array_merge($fieldRules, $field->validation_rules);
            }
            
            $rules[$field->name] = $fieldRules;
        }
        
        return $rules;
    }
}