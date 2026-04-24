<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'product_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'product_id', 'name', 'product_type', 'category_type', 
        'price', 'image_url', 'detail', 'description', 'status', 'activated_at'
    ];

    protected $casts = [
        'image_url'    => 'array', 
        'detail'       => 'array',
        'activated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->product_id)) {
                $model->product_id = (string) Str::uuid();
            }
        });
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'product_type', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_type');
    }
}