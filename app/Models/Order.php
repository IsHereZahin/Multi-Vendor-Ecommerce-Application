<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function state()
    {
        return $this->belongsTo(ShipState::class, 'state_id');
    }

    public function district()
    {
        return $this->belongsTo(ShipDistrict::class, 'district_id');
    }

    public function division()
    {
        return $this->belongsTo(ShipDivision::class, 'division_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
