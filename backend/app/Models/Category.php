<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'active'])]
class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected function casts(): array
    {
        return [
            'active' => 'boolean'
        ];
    }

     public function products()
    {
        return $this->hasMany(Product::class);
    }
}
