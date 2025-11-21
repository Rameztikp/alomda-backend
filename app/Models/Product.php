<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'price',
        'image_url',
        'is_active',
        // إضافة المفتاح الخارجي للصنف هنا
        'category_id', 
    ];

    /**
     * علاقة المنتج مع الصنف (المنتج ينتمي لصنف واحد).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}