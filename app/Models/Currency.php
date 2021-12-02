<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "is_real",
        "exchange_rate"
    ];

    protected $attributes = [
        'is_real' => false,
    ];
}
