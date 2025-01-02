<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'color',
        'size',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getTotal()
    {
        return $this->with('product')
            ->where('user_id', auth()->id())
            ->get()
            ->sum(function ($cartItem) {
                $product = $cartItem->product;
                $productPrice = $product->discount_price ? $product->discount_price : $product->selling_price;
                return $productPrice * $cartItem->quantity;
            });
    }
}
