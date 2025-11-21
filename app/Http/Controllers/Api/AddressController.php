<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();

        return response()->json([
            'status' => 'success',
            'data' => $addresses,
            'message' => 'تم جلب قائمة العناوين بنجاح.'
        ], 200);
    }
}
