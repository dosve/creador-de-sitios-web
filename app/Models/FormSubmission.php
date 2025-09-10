<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'data',
        'ip_address',
        'user_agent',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    // Relaciones
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    // Scopes
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Métodos de utilidad
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    public function getFieldValue($fieldName)
    {
        return $this->data[$fieldName] ?? null;
    }

    public function getFormattedData()
    {
        $formatted = [];
        
        foreach ($this->form->fields as $field) {
            $value = $this->getFieldValue($field->name);
            
            if ($value !== null) {
                $formatted[$field->label] = $this->formatFieldValue($field, $value);
            }
        }
        
        return $formatted;
    }

    private function formatFieldValue($field, $value)
    {
        switch ($field->type) {
            case 'checkbox':
                return is_array($value) ? implode(', ', $value) : ($value ? 'Sí' : 'No');
            case 'file':
                return is_array($value) ? implode(', ', $value) : $value;
            case 'date':
                return $value ? \Carbon\Carbon::parse($value)->format('d/m/Y') : '';
            case 'datetime-local':
                return $value ? \Carbon\Carbon::parse($value)->format('d/m/Y H:i') : '';
            case 'time':
                return $value ? \Carbon\Carbon::parse($value)->format('H:i') : '';
            default:
                return $value;
        }
    }

    public function getSummaryAttribute()
    {
        $data = $this->getFormattedData();
        $summary = [];
        
        // Tomar los primeros 3 campos para el resumen
        $count = 0;
        foreach ($data as $label => $value) {
            if ($count >= 3) break;
            $summary[] = $label . ': ' . (is_string($value) && strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value);
            $count++;
        }
        
        return implode(' | ', $summary);
    }

    // Métodos para notificaciones
    public function shouldSendNotification()
    {
        $emailSettings = $this->form->email_settings;
        
        if (!$emailSettings || !isset($emailSettings['notify_on_submission'])) {
            return false;
        }
        
        return $emailSettings['notify_on_submission'] === true;
    }

    public function getNotificationEmails()
    {
        $emailSettings = $this->form->email_settings;
        
        if (!$emailSettings || !isset($emailSettings['notification_emails'])) {
            return [];
        }
        
        $emails = $emailSettings['notification_emails'];
        
        return is_array($emails) ? $emails : explode(',', $emails);
    }
}