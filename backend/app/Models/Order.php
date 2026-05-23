<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'coupon_id',
    'subtotal',
    'discount',
    'freight',
    'total',
    'type_delivery',
    'status_order'
])]
class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'freight' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items()
    {
        return $this->hasMany(ItemOrder::class, 'order_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
