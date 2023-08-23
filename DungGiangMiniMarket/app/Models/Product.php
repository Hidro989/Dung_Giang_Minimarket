<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'unit_price',
        'category_id',
        'featured_image',
        'stock'
    ];
    use HasFactory;
}
