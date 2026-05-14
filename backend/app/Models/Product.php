<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['category_id', 'name', 'description_short', 
'description_long', 'stock', 'image', 'price', 'active'])]
class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'active' => 'boolean'
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ImageProduct::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }

    public function itensOrder()
    {
        return $this->hasMany(ItemOrder::class);
    }

    public function itensCart()
    {
        return $this->hasMany(ItemCart::class);
    }
}
