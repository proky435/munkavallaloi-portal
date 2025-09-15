<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreRegisteredUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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
        'registration_token',
        'is_registered',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'is_registered' => 'boolean',
    ];

    /**
     * Get the workplace that the pre-registered user belongs to.
     */
    public function workplace(): BelongsTo
    {
        return $this->belongsTo(Workplace::class);
    }
}
