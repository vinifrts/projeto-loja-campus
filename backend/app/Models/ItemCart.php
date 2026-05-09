<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['cart_id', 'product_id', 'amount', 'unit_price'])]
class ItemCart extends Model
{
    use HasFactory;
    protected $table = 'item_carts';

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2'
        ];
    }

     public function cart()
    {
        return $this->belongsTo(ShoppingCart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
