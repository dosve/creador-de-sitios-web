<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'name',
        'label',
        'type',
        'placeholder',
        'help_text',
        'options',
        'validation_rules',
        'is_required',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
            'validation_rules' => 'array',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // Relaciones
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // Métodos de utilidad
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'text' => 'Texto',
            'email' => 'Email',
            'password' => 'Contraseña',
            'number' => 'Número',
            'tel' => 'Teléfono',
            'url' => 'URL',
            'textarea' => 'Área de texto',
            'select' => 'Lista desplegable',
            'checkbox' => 'Casilla de verificación',
            'radio' => 'Botón de opción',
            'file' => 'Archivo',
            'date' => 'Fecha',
            'time' => 'Hora',
            'datetime-local' => 'Fecha y hora',
            'hidden' => 'Campo oculto',
            default => ucfirst($this->type)
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'text' => 'document-text',
            'email' => 'envelope',
            'password' => 'lock-closed',
            'number' => 'hashtag',
            'tel' => 'phone',
            'url' => 'link',
            'textarea' => 'document-text',
            'select' => 'list-bullet',
            'checkbox' => 'check-square',
            'radio' => 'circle-stack',
            'file' => 'paper-clip',
            'date' => 'calendar',
            'time' => 'clock',
            'datetime-local' => 'calendar-days',
            'hidden' => 'eye-slash',
            default => 'document'
        };
    }

    // Métodos para validación
    public function getValidationRule()
    {
        $rules = [];
        
        if ($this->is_required) {
            $rules[] = 'required';
        }
        
        // Reglas específicas por tipo
        switch ($this->type) {
            case 'email':
                $rules[] = 'email';
                break;
            case 'url':
                $rules[] = 'url';
                break;
            case 'number':
                $rules[] = 'numeric';
                break;
            case 'file':
                $rules[] = 'file';
                break;
            case 'date':
                $rules[] = 'date';
                break;
            case 'time':
                $rules[] = 'date_format:H:i';
                break;
            case 'datetime-local':
                $rules[] = 'date';
                break;
        }
        
        // Agregar reglas personalizadas
        if ($this->validation_rules) {
            $rules = array_merge($rules, $this->validation_rules);
        }
        
        return $rules;
    }

    // Métodos para opciones
    public function getOptionsArray()
    {
        if (!$this->options) {
            return [];
        }
        
        return is_array($this->options) ? $this->options : json_decode($this->options, true);
    }

    public function setOptionsArray($options)
    {
        $this->options = is_array($options) ? $options : json_decode($options, true);
    }

    // Métodos para el constructor
    public function duplicate()
    {
        $newField = $this->replicate();
        $newField->name = $this->name . '_copy';
        $newField->label = $this->label . ' (Copia)';
        $newField->sort_order = $this->form->fields()->max('sort_order') + 1;
        $newField->save();
        
        return $newField;
    }
}