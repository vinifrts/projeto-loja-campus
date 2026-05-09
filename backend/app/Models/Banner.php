<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'image', 'destination_link',
'active', 'start_date', 'end_date'])]
class Banner extends Model
{
    use HasFactory;
    protected $table = 'banners';

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date'
        ];
    }
}
