<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Merchant
 *
 * @property int $id
 * @property int $user_id
 * @property string $business_name
 * @property string $business_type
 * @property string|null $description
 * @property string|null $logo
 * @property string|null $banner
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 * @property array|null $operating_hours
 * @property bool $is_open
 * @property float $rating
 * @property int $total_reviews
 * @property int $total_orders
 * @property float $delivery_radius_km
 * @property float $minimum_order_amount
 * @property float $delivery_fee
 * @property bool $is_verified
 * @property bool $is_active
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|Merchant whereOpen()
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Merchant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'description',
        'logo',
        'banner',
        'address',
        'latitude',
        'longitude',
        'operating_hours',
        'is_open',
        'rating',
        'total_reviews',
        'total_orders',
        'delivery_radius_km',
        'minimum_order_amount',
        'delivery_fee',
        'is_verified',
        'is_active',
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
        'operating_hours' => 'array',
        'is_open' => 'boolean',
        'rating' => 'decimal:2',
        'delivery_radius_km' => 'decimal:2',
        'minimum_order_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Get the user that owns the merchant profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products for this merchant.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the orders for this merchant.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'merchant_id', 'user_id');
    }

    /**
     * Scope a query to only include active merchants.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include verified merchants.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope a query to only include open merchants.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereOpen($query)
    {
        return $query->where('is_open', true);
    }
}