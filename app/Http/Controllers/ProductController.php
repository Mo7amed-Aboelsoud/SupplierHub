<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'image' => $imagePath,
            'user_id' => auth()->id(), // حل مشكلة user_id اللي ظهرتلك
        ]);

        return redirect()->route('dashboard');
    }







public function index()
{
    $products = Product::where('user_id', auth()->id())->get();
    // جلب الطلبات الخاصة بمنتجات هذا المورد فقط
    $orders = Order::whereHas('product', function($q) {
        $q->where('user_id', auth()->id());
    })->with('product')->get();

    // نستخدم 'dashboard' مباشرة لأن الملف بالخارج
    return view('dashboard', compact('products', 'orders'));
}



public function shop(Request $request)
{
    $query = Product::query();

    // البحث بالاسم
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // التصفية بالقسم
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // التصفية بالسعر
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    $products = $query->with('user')->latest()->get();
    $categories = Product::distinct()->pluck('category');

    return view('shop', compact('products', 'categories'));
}
public function destroy($id)
{
    $product = Product::findOrFail($id);

    // تأكد إن المورد اللي بيمسح هو صاحب المنتج فعلاً (اختياري للأمان)
    if ($product->user_id !== auth()->id()) {
        return back()->with('error', 'Unauthorized action.');
    }

    $product->delete();
    return back()->with('success', 'Product deleted successfully!');
}
}
