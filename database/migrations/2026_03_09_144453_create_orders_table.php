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

       Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // هذا العمود هو المطعم المشتري
            $table->foreignId('restaurant_id')->references('id')->on('users')->onDelete('cascade'); // المطعم
            $table->foreignId('supplier_id')->references('id')->on('users')->onDelete('cascade');   // المورد
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // المنتج
             // الكمية
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 10, 2); // السعر الكلي
            $table->string('status')->default('pending'); // حالة الطلب (انتظار، مقبول، مرفوض)
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
