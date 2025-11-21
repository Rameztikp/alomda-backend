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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // الأسماء متعددة اللغات
            $table->string('name_ar', 100);
            $table->string('name_en', 100)->nullable();
            
            // الرابط القصير (Slug) لاستخدامه في الروابط
            $table->string('slug', 100)->unique(); 
            
            // حالة عرض الصنف
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};