<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class AlomdaProductController extends Controller
{
    /**
     * جلب المنتجات والأصناف لإظهارها في واجهة الـ React
     */
    public function showcase()
    {
        // جلب كل المنتجات النشطة مع تحميل علاقة الصنف
        $products = Product::with('category')
            ->where('is_active', true)
            ->get();

        // جلب كل الأصناف (Categories)
        $categories = Category::all();

        // إرجاع البيانات بالهيكل المطلوب
        return response()->json([
            'status' => 'success',
            'data' => [
                'products' => $products,
                'categories' => $categories,
            ],
            'message' => 'تم جلب البيانات بنجاح.'
        ], 200);
    }
}
