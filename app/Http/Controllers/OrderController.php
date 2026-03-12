<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    // حذف/إلغاء الطلب
    public function destroy($id)
{
    // بنجيب الطلب ونتأكد إنه يخص المستخدم اللي عامل Login
    $order = Order::where('id', $id)
                  ->where('user_id', auth()->id())
                  ->firstOrFail();

    $order->delete();

    return back()->with('success', 'Order cancelled successfully!');
}

    // للمورد: قبول ورفض
    public function accept($id) { Order::findOrFail($id)->update(['status' => 'accepted']); return back(); }
    public function reject($id) { Order::findOrFail($id)->update(['status' => 'rejected']); return back(); }




// 1. عرض طلبات المطعم الحالي
public function myOrders(): View
{
    // بنجيب الطلبات اللي الـ restaurant_id بتاعها هو id المستخدم الحالي
    $orders = Order::with('product')
        ->where('restaurant_id', auth()->id())
        ->latest()
        ->get();

    return view('restaurant.orders', compact('orders'));
}

// 2. تنفيذ طلب شراء (هنا حل المشكلة)
// 2. تنفيذ طلب شراء (حل مشكلة الـ quantity)
public function placeOrder($product_id)
{
    $product = Product::findOrFail($product_id);

    $quantity = 1;

    $total_price = $product->price * $quantity;

    Order::create([
        'product_id'    => $product->id,
        'restaurant_id' => auth()->id(),
        'user_id'       => auth()->id(),
        'supplier_id'   => $product->user_id,
        'status'        => 'pending',
        'quantity'      => $quantity,
        'total_price'   => $total_price
    ]);

    return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
}

}
