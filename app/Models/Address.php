<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // الحقول القابلة للكتابة (mass assignable)
    protected $fillable = [
        'street',       // الشارع
        'city',         // المدينة
        'state',        // المحافظة/الولاية
        'postal_code',  // الرمز البريدي
    ];

    // إذا كان اسم جدولك مختلفًا عن "addresses"، حدده هنا
    // protected $table = 'my_addresses_table';
}
