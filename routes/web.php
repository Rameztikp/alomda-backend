<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address; // 💡 تأكد من استيراد نموذج العنوان الصحيح

class AddressController extends Controller
{
    /**
     * جلب كل العناوين وإرجاعها كـ JSON.
     * هذا هو الكود الذي سيعيد البيانات للواجهة الأمامية.
     * * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // 1. جلب كل العناوين من قاعدة البيانات.
        // يفضل استخدام ()paginate() للتعامل مع البيانات الكبيرة
        $addresses = Address::all(); 

        // 2. إرجاع مجموعة البيانات في استجابة JSON
        // Laravel ستقوم تلقائياً بتحويل الـ Collection إلى JSON.
        return response()->json([
            'status' => 'success',
            'data' => $addresses,
            'message' => 'تم جلب قائمة العناوين بنجاح.'
        ], 200); // رمز الحالة 200 يعني OK (نجاح)
    }

    // 💡 يمكنك إضافة وظائف أخرى هنا مثل show(لعرض عنوان واحد), store (لإضافة عنوان), etc.
}