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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المورد صاحب المنتج
            $table->string('name'); // اسم المنتج (مثلاً: لحم بلدي)
            $table->string('category'); // نوع المنتج (خضروات، لحوم، أسماك)
            $table->decimal('price', 8, 2); // السعر
            $table->string('image')->nullable(); // صورة المنتج
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
