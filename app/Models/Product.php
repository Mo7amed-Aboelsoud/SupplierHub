<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // أضفنا category هنا لأنك بتستخدمها في الـ Store والـ Filter
    protected $fillable = ['name', 'price', 'user_id', 'image', 'category'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // أضف هذه العلاقة عشان المورد يشوف طلبات المنتج ده
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
