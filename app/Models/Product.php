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

    /**
     * Get the full URL for the product image.
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function getImageUrlAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        // If it's already a full URL, return as is
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        // Remove any leading slashes or 'storage/' prefix to avoid double slashes
        $path = ltrim($value, '/');
        $path = str_starts_with($path, 'storage/') ? substr($path, 8) : $path;

        // Return the full URL using localhost:8000
        return 'http://localhost:8000/storage/' . $path;
    }
}