{{-- <x-layouts::app :title="__('Dashboard')">
    <div class="p-6" style="direction: rtl;">
        <div class="mb-8 bg-white p-6 rounded-xl border border-neutral-200 shadow-sm">
            <h3 class="text-lg font-bold mb-4 text-neutral-800">➕ إضافة صنف جديد (لحوم / خضروات)</h3>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="name" placeholder="اسم الصنف (مثلاً: كبده)" class="border border-neutral-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>

                    <select name="category" class="border border-neutral-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="لحوم">لحوم</option>
                        <option value="خضروات">خضروات</option>
                        <option value="دواجن">دواجن</option>
                    </select>

                    <input type="number" name="price" placeholder="السعر" class="border border-neutral-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>

                    <input type="file" name="image" class="text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <button type="submit" class="mt-4 bg-black text-white px-6 py-2 rounded-lg font-bold hover:bg-neutral-800 transition">
                    حفظ المنتج
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-xl border border-neutral-200 shadow-sm">
            <h3 class="text-lg font-bold mb-4 text-neutral-800">📋 بضاعتك الحالية</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50">
                            <th class="p-3">الصورة</th>
                            <th class="p-3">الاسم</th>
                            <th class="p-3">القسم</th>
                            <th class="p-3">السعر</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr class="border-b border-neutral-50 hover:bg-neutral-50">
                            <td class="p-3 text-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" width="50" class="rounded-lg shadow-sm mx-auto">
                                @else
                                    <span class="text-neutral-400 text-xs">لا توجد صورة</span>
                                @endif
                            </td>
                            <td class="p-3 font-medium">{{ $product->name }}</td>
                            <td class="p-3 text-neutral-600">{{ $product->category }}</td>
                            <td class="p-3 font-bold text-green-600">{{ $product->price }} جنيه</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center text-neutral-400">لا توجد منتجات حالياً. ابدأ بإضافة منتجك الأول!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app> --}}

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard | Control Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .navbar { background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 15px 0; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .product-img { width: 50px; height: 50px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; }
        .status-badge { font-size: 0.75rem; font-weight: 700; padding: 5px 12px; border-radius: 50px; }
        .btn-round { border-radius: 50px; font-weight: 600; padding: 8px 20px; }
        .stat-card { border-left: 5px solid #0d6efd; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top mb-4 shadow-sm">
        <div class="container text-start">
            <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('dashboard') }}">
                <i class="fas fa-boxes-stacked me-2"></i> SupplierHub
            </a>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <div class="text-end d-none d-md-block">
                    <small class="text-muted d-block">Welcome back,</small>
                    <span class="fw-bold">{{ auth()->user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm btn-round">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container pb-5">

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stat-card p-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="fas fa-shopping-basket text-primary"></i>
                        </div>
                        <div class="text-start">
                            <small class="text-muted fw-bold d-block text-uppercase">Pending Orders</small>
                            <h3 class="fw-bold m-0 text-warning">{{ $orders->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card p-4 shadow-sm text-start">
                    <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-plus-circle text-success me-2"></i>New Product</h5>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Product Name</label>
                            <input type="text" name="name" class="form-control bg-light border-0" placeholder="e.g. Fresh Salmon" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Category</label>
                            <select name="category" class="form-select bg-light border-0">
                                <option value="Fish">Fish</option>
                                <option value="Meat">Meat</option>
                                <option value="Vegetables">Vegetables</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Price ($)</label>
                            <input type="number" name="price" class="form-control bg-light border-0" placeholder="0.00" step="0.01" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Image File</label>
                            <input type="file" name="image" class="form-control bg-light border-0">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-round">
                            <i class="fas fa-save me-2"></i>Add to Stock
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card p-4 shadow-sm text-start">
                    <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-warehouse me-2"></i>Inventory Stock</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr class="small text-muted">
                                    <th>IMAGE</th>
                                    <th>PRODUCT NAME</th>
                                    <th>PRICE</th>
                                    <th class="text-center">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $product->image) }}" class="product-img" onerror="this.src='https://via.placeholder.com/150'">
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $product->name }}</div>
                                        <span class="badge bg-secondary-subtle text-secondary fw-normal">{{ $product->category }}</span>
                                    </td>
                                    <td class="text-success fw-bold">${{ number_format($product->price, 2) }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="m-0">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm border-0"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No products in stock.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-start">
                <div class="card p-4 shadow-sm">
                    <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-shopping-cart text-warning me-2"></i>Incoming Restaurant Orders</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr class="small text-muted text-uppercase">
                                    <th>Order ID</th>
                                    <th>Product Item</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th class="text-center">Decision</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td class="fw-bold">#{{ $order->id }}</td>
                                    <td>{{ $order->product->name ?? 'Deleted Item' }}</td>
                                    <td class="text-success fw-bold">${{ number_format($order->total_price, 2) }}</td>
                                    <td>
                                        <span class="badge status-badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'accepted' ? 'success' : 'danger') }}-subtle text-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'accepted' ? 'success' : 'danger') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($order->status == 'pending')
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="{{ route('orders.accept', $order->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm btn-round">Approve</button>
                                            </form>
                                            <form action="{{ route('orders.reject', $order->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm btn-round">Reject</button>
                                            </form>
                                        </div>
                                        @else
                                            <span class="text-muted small">Processed</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">No orders received yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
