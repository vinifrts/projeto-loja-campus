<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'product_id', 'amount',
'unit_price', 'subtotal_item', 'total' , 'type_delivery', 'status_order'])]
class ItemOrder extends Model
{
    use HasFactory;
    protected $table = 'item_orders';

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'subtotal_item' => 'decimal:2',
        ];
    }

    public function order()
    {
     return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
