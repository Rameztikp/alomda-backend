<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // إضافة حقل category_id بعد حقل id
            $table->foreignId('category_id')
                  ->after('id')
                  ->constrained() // هذا سيربطه بجدول الفئات تلقائياً
                  ->onDelete('cascade'); // إذا تم حذف الفئة، سيتم حذف المنتجات المرتبطة بها
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // حذف المفتاح الخارجي أولاً
            $table->dropForeign(['category_id']);
            // ثم حذف الحقل
            $table->dropColumn('category_id');
        });
    }
};