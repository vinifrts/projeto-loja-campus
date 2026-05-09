<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'type_payment', 'value',
'status_payment', 'data_payment'])]
class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'data_payment' => 'datetime',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
