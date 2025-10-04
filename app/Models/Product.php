<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'description',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'price' => 'float',
        'stock' => 'integer',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
