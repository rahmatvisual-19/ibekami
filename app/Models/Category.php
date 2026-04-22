<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'type_id', 'name'
    ];

    /**
     * Relationship: A Category belongs to a Type
     */
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_type');
    }
}