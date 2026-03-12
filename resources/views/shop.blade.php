<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace | SupplierHub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #0d6efd !important; padding: 12px 0; }
        .filter-card { border: none; border-radius: 15px; background: white; padding: 20px; border: 1px solid #eee; }
        .product-card { border: none; border-radius: 15px; transition: 0.3s; background: white; overflow: hidden; height: 100%; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
        .img-container { height: 180px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; }
        .product-img { width: 100%; height: 100%; object-fit: cover; }
        .nav-link.active { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

 <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top mb-4" style="background-color: #0d6efd;">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('shop') }}">
            <i class="fas fa-store me-2"></i> Marketplace
        </a>
        <div class="collapse navbar-collapse" id="shopNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                @auth
                    {{-- زرار طلباتي للمطعم --}}
                    @if(auth()->user()->role === 'restaurant')
                        <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-primary shadow-sm">
                            <i class="fas fa-shopping-bag me-1"></i> My Orders
                        </a>
                    @endif

                    {{-- زرار الداشبورد للمورد --}}
                    @if(auth()->user()->role === 'supplier')
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-primary shadow-sm">
                            <i class="fas fa-chart-line me-1"></i> Dashboard
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm rounded-pill px-3 fw-bold">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

    <div class="container mb-5">
        <div class="filter-card shadow-sm mb-4">
            <form action="{{ route('shop') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control rounded-pill" placeholder="Search products..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select rounded-pill">
                        <option value="">All Categories</option>
                        {{-- هنا بيسحب الأقسام اللي الموردين كتبوها في الداشبورد --}}
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="min_price" class="form-control rounded-pill" placeholder="Min Price" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_price" class="form-control rounded-pill" placeholder="Max Price" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="card product-card shadow-sm">
                        <div class="img-container">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="product-img">
                            @else
                                <i class="fas fa-image fa-3x text-light"></i>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill mb-2 align-self-start" style="font-size: 11px;">
                                {{ $product->category }}
                            </span>
                            <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                            <p class="text-muted small mb-3">Supplier: {{ $product->user->name ?? 'N/A' }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="text-success fw-bold fs-5">${{ number_format($product->price, 2) }}</span>
                                <form action="{{ route('order.place', $product->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">Buy</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search fa-4x mb-3 text-light"></i>
                    <h4 class="text-muted">No products found matching your search.</h4>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>
