<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * الأعمدة التي يمكن تعبئتها جماعياً.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'slug',
        'is_active',
    ];

    /**
     * علاقة الصنف مع المنتجات (الصنف الواحد يمكن أن يحتوي على عدة منتجات).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}