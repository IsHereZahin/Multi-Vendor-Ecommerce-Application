<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Table name (optional, if it deviates from convention)
    protected $table = 'carts';

    // Mass-assignable attributes
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'color',
        'size',
    ];

    /**
     * Relationships
     */

    // A cart item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // A cart item belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessors & Mutators
     */

    // Example accessor for formatted quantity
    public function getFormattedQuantityAttribute()
    {
        return $this->quantity . ' pcs';
    }

    /**
     * Scopes
     */

    // Scope to filter cart items by user
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
