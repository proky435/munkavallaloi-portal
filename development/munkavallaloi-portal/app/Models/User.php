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
        'workplace',
        'workplace_id',
        'accessible_categories',
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
        'accessible_categories' => 'array',
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
    // If user has specific accessible categories set, use only those
    if ($this->accessible_categories && is_array($this->accessible_categories) && !empty($this->accessible_categories)) {
        return in_array($categoryId, $this->accessible_categories);
    }
    
    // If user has role-based permissions for all tickets
    if ($this->role && $this->role->hasPermission('manage_all_tickets')) {
        return true;
    }
    
    // Super admins can access all categories (only if no specific categories are set)
    if ($this->is_admin) {
        return true;
    }
    
    // Regular users can access all categories if no restrictions are set
    if (empty($this->accessible_categories)) {
        return true;
    }
    
    // If accessible_categories is empty array, deny access
    return false;
}

/**
 * Get categories that the user can access
 */
public function getAccessibleCategories()
{
    // If user has specific accessible categories set, use only those
    if ($this->accessible_categories && is_array($this->accessible_categories) && !empty($this->accessible_categories)) {
        return \App\Models\Category::whereIn('id', $this->accessible_categories)->get();
    }
    
    // If user has role-based permissions for all tickets
    if ($this->role && $this->role->hasPermission('manage_all_tickets')) {
        return \App\Models\Category::all();
    }
    
    // Super admins can access all categories (only if no specific categories are set)
    if ($this->is_admin) {
        return \App\Models\Category::all();
    }
    
    // Regular users can access all categories if no restrictions are set
    if (empty($this->accessible_categories)) {
        return \App\Models\Category::all();
    }
    
    // If accessible_categories is empty array, return empty collection
    return collect();
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
 * Check if user has a specific role
 */
public function hasRole(string $roleName): bool
{
    if (!$this->role) {
        return false;
    }
    
    return $this->role->name === $roleName;
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

    /**
     * Assign categories to user for admin management
     */
    public function assignCategories(array $categoryIds)
    {
        $this->update(['accessible_categories' => $categoryIds]);
    }

    /**
     * Get categories this user can manage in admin panel
     */
    public function getManageableCategories()
    {
        // If user has specific accessible categories set, use only those for admin management
        if ($this->accessible_categories && is_array($this->accessible_categories) && !empty($this->accessible_categories)) {
            return \App\Models\Category::whereIn('id', $this->accessible_categories)->get();
        }
        
        // If user has role-based permissions for all tickets
        if ($this->role && $this->role->hasPermission('manage_all_tickets')) {
            return \App\Models\Category::all();
        }
        
        // Super admins can manage all categories (only if no specific categories are set)
        if ($this->is_admin) {
            return \App\Models\Category::all();
        }
        
        // Regular users cannot manage any categories in admin
        return collect();
    }

    /**
     * User workplace assignments relationship
     */
    public function userWorkplaces(): HasMany
    {
        return $this->hasMany(UserWorkplace::class);
    }

    /**
     * Get all permanent workplace assignments
     */
    public function getPermanentWorkplaces()
    {
        return $this->userWorkplaces()
                   ->permanent()
                   ->with('workplace')
                   ->get()
                   ->pluck('workplace');
    }

    /**
     * Get all current workplaces (permanent + temporary active)
     */
    public function getAllCurrentWorkplaces()
    {
        return $this->userWorkplaces()
                   ->current()
                   ->with('workplace')
                   ->get()
                   ->pluck('workplace');
    }

    /**
     * Get future workplace assignments
     */
    public function getFutureWorkplaces()
    {
        return $this->userWorkplaces()
                   ->with('workplace')
                   ->future()
                   ->get();
    }

    /**
     * Get past workplace assignments
     */
    public function getPastWorkplaces()
    {
        return $this->userWorkplaces()
                   ->with('workplace')
                   ->past()
                   ->get();
    }

    /**
     * Get primary current workplace (for backward compatibility)
     */
    public function getCurrentWorkplace()
    {
        $current = $this->userWorkplaces()
                       ->current()
                       ->with('workplace')
                       ->first();
        
        if ($current) {
            return $current->workplace;
        }
        
        // Fallback to old workplace relationship if exists
        if ($this->workplace_id) {
            return $this->belongsTo(Workplace::class, 'workplace_id')->first();
        }
        
        return null;
    }

    /**
     * Get next workplace transition
     */
    public function getNextWorkplaceTransition()
    {
        return $this->userWorkplaces()
                   ->with('workplace')
                   ->future()
                   ->orderBy('start_date')
                   ->first();
    }

    /**
     * Check if user has workplace transition scheduled
     */
    public function hasUpcomingTransition(): bool
    {
        return $this->getFutureWorkplaces()->isNotEmpty();
    }

    /**
     * Get all workplace assignments for display
     */
    public function getAllWorkplaceAssignments()
    {
        return $this->userWorkplaces()
                   ->with('workplace')
                   ->orderBy('start_date')
                   ->get();
    }
}
