<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['product_id', 'url_image', 'subtitle', 'principal'])]
class ImageProduct extends Model
{
    use HasFactory;
    protected $table = 'image_products';

    protected function casts(): array
    {
        return [
            'principal' => 'boolean'
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
