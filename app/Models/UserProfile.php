<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserProfile
 *
 * @property int $id
 * @property int $user_id
 * @property string $role
 * @property string|null $phone
 * @property string|null $avatar
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $firebase_token
 * @property bool $is_online
 * @property bool $is_verified
 * @property \Illuminate\Support\Carbon|null $last_active
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereRole($role)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereOnline()
 * @method static \Database\Factories\UserProfileFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class UserProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'role',
        'phone',
        'avatar',
        'address',
        'latitude',
        'longitude',
        'firebase_token',
        'is_online',
        'is_verified',
        'last_active',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_online' => 'boolean',
        'is_verified' => 'boolean',
        'last_active' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include profiles with specified role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope a query to only include verified profiles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope a query to only include online profiles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereOnline($query)
    {
        return $query->where('is_online', true);
    }
}