<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_first_login',
        'role_id',
        'workplace_id',
        'phone',
        'birth_date',
        'birth_place',
        'street_address',
        'city',
        'postal_code',
        'country',
        'bank_account_number',
        'tax_number',
        'social_security_number',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
        'is_first_login' => 'boolean',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

/**
 * Get the role that belongs to the user
 */
public function role(): BelongsTo
{
    return $this->belongsTo(Role::class);
}

/**
 * Check if user can access tickets from a specific category
 */
public function canAccessCategory($categoryId): bool
{
    // Super admins can access all categories
    if ($this->is_admin && !$this->accessible_categories) {
        return true;
    }
    
    // Check if category is in user's accessible categories
    return $this->accessible_categories && in_array($categoryId, $this->accessible_categories);
}

/**
 * Check if user has a specific permission
 */
public function hasPermission(string $permission): bool
{
    if (!$this->role) {
        return false;
    }
    
    return $this->role->hasPermission($permission);
}

    /**
     * Get the workplace that belongs to the user
     */
    public function workplace(): BelongsTo
    {
        return $this->belongsTo(Workplace::class);
    }

    /**
     * Alias for workplace relationship for backward compatibility
     */
    public function workplaceModel(): BelongsTo
    {
        return $this->workplace();
    }

    /**
     * Get all workplaces associated with the user.
     */
    public function workplaces()
    {
        return $this->belongsToMany(Workplace::class, 'user_workplaces')
                    ->withPivot('is_primary', 'start_date', 'end_date')
                    ->withTimestamps();
    }

    /**
     * Get the primary workplace for the user.
     */
    public function primaryWorkplace()
    {
        return $this->workplaces()->wherePivot('is_primary', true)->first();
    }
}
