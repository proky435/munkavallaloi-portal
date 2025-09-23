<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataChangeRequest extends Model
{
    protected $fillable = [
        'user_id',
        'data_change_type_id',
        'title',
        'description',
        'form_data',
        'attachments',
        'status',
        'admin_notes',
        'processed_by',
        'processed_at',
        'scheduled_for',
        'is_scheduled',
        'reminder_sent_at'
    ];

    protected $casts = [
        'form_data' => 'array',
        'attachments' => 'array',
        'processed_at' => 'datetime',
        'scheduled_for' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'is_scheduled' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dataChangeType(): BelongsTo
    {
        return $this->belongsTo(DataChangeType::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
