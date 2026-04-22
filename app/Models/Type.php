<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types';

    protected $fillable = ['name', 'image_url'];

    /**
     * Relationship: A Type has many Categories
     */
    public function categories()
    {
        return $this->hasMany(Category::class, 'type_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_type','id');
    }
}