<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $merchant_id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property string $category
 * @property float $price
 * @property float|null $promo_price
 * @property bool $is_promo_active
 * @property bool $is_available
 * @property int|null $stock_quantity
 * @property array|null $variants
 * @property int $preparation_time_minutes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Merchant $merchant
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAvailable()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategory($category)

 * 
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'image',
        'category',
        'price',
        'promo_price',
        'is_promo_active',
        'is_available',
        'stock_quantity',
        'variants',
        'preparation_time_minutes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'promo_price' => 'decimal:2',
        'is_promo_active' => 'boolean',
        'is_available' => 'boolean',
        'variants' => 'array',
    ];

    /**
     * Get the merchant that owns the product.
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get the order items for this product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to only include available products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope a query to filter by category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the current price (promo price if active, otherwise regular price).
     */
    public function getCurrentPrice(): float
    {
        if ($this->is_promo_active && $this->promo_price) {
            return $this->promo_price;
        }
        
        return $this->price;
    }
}