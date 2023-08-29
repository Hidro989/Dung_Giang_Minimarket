<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function variants() : HasMany
    {
        return $this->hasMany(Variant::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
