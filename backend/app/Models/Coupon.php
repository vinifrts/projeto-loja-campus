<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['code', 'description', 'type_discount', 'discount_value',
'start_date', 'end_date', 'active'])]
class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date'
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
