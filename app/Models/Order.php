<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // لازم تضيف quantity هنا، لو مش موجودة Laravel بيمسحها من الـ Create
    protected $fillable = [
    'product_id',
    'restaurant_id',
    'user_id',
    'supplier_id',
    'status',
    'quantity',
    'total_price'
];

    // لو مش عاوز تكتب 'quantity' => 1 في الـ Controller كل شوية، ضيف السطر ده:
    protected $attributes = [
        'quantity' => 1,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
