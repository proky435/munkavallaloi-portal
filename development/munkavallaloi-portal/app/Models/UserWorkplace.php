<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserWorkplace extends Model
{
    protected $fillable = [
        'user_id',
        'workplace_id',
        'is_primary',
        'start_date',
        'end_date',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_primary' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workplace(): BelongsTo
    {
        return $this->belongsTo(Workplace::class);
    }

    /**
     * Check if this assignment is currently active
     */
    public function isCurrentlyActive(): bool
    {
        $now = Carbon::now()->toDateString();
        
        return $this->is_active && 
               $this->start_date <= $now && 
               ($this->end_date === null || $this->end_date >= $now);
    }

    /**
     * Check if this assignment will be active in the future
     */
    public function isFutureActive(): bool
    {
        $now = Carbon::now()->toDateString();
        
        return $this->is_active && $this->start_date > $now;
    }

    /**
     * Check if this assignment was active in the past
     */
    public function isPastActive(): bool
    {
        $now = Carbon::now()->toDateString();
        
    }

    /**
     * Get the status of this workplace assignment
     */
    public function getStatusAttribute()
    {
        // Permanent assignments (no dates) are always current
        if (is_null($this->start_date) && is_null($this->end_date)) {
            return 'permanent';
        }
        
        $now = Carbon::now();
        
        if ($this->start_date && $this->start_date->isFuture()) {
            return 'future';
        }
        
        if ($this->end_date && $this->end_date->isPast()) {
            return 'past';
        }
        
        return 'current';
    }

    public function getIsPermanentAttribute()
    {
        return is_null($this->start_date) && is_null($this->end_date);
    }

    /**
     * Scope for current assignments (including permanent ones)
     */
    public function scopeCurrent($query)
    {
        $now = Carbon::now()->toDateString();
        
        return $query->where('is_active', true)
                    ->where(function($q) use ($now) {
                        // Permanent assignments (no dates)
                        $q->where(function($subQ) {
                            $subQ->whereNull('start_date')
                                 ->whereNull('end_date');
                        })
                        // Or time-based assignments that are currently active
                        ->orWhere(function($subQ) use ($now) {
                            $subQ->where('start_date', '<=', $now)
                                 ->where(function($dateQ) use ($now) {
                                     $dateQ->whereNull('end_date')
                                           ->orWhere('end_date', '>=', $now);
                                 });
                        });
                    });
    }

    /**
     * Scope for permanent assignments
     */
    public function scopePermanent($query)
    {
        return $query->where('is_active', true)
                    ->whereNull('start_date')
                    ->whereNull('end_date');
    }

    /**
     * Scope for future assignments
     */
    public function scopeFuture($query)
    {
        $now = Carbon::now()->toDateString();
        
        return $query->where('is_active', true)
                    ->where('start_date', '>', $now);
    }

    /**
     * Scope for past assignments
     */
    public function scopePast($query)
    {
        $now = Carbon::now()->toDateString();
        
        return $query->where('end_date', '<', $now);
    }
}
