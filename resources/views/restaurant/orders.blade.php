<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders | Restaurant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-utensils me-2"></i> Restaurant Portal
            </a>

            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="{{ route('shop') }}" class="btn btn-outline-light rounded-pill px-4">
                    <i class="fas fa-store me-2"></i> Back to Shop
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0 text-dark">
                <i class="fas fa-shopping-bag me-2 text-primary"></i> My Orders
            </h3>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th class="ps-4 py-3 text-start">Product</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Price</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Date</th>
                            <th class="pe-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary text-start">{{ $order->product->name }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $order->product->category }}</span></td>
                            <td class="text-success fw-bold">${{ number_format($order->product->price, 2) }}</td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Waiting</span>
                                @elseif($order->status == 'accepted')
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i> Accepted</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times me-1"></i> Rejected</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $order->created_at->format('d M, Y') }}</td>
                            <td class="pe-4">
                                @if($order->status == 'pending')
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="fas fa-trash-alt me-1"></i> Cancel
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small"><i class="fas fa-lock me-1"></i> Completed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-box-open mb-3 opacity-25" style="font-size: 4rem;"></i>
                                    <p class="fs-5">You haven't placed any orders yet.</p>
                                    <a href="{{ route('shop') }}" class="btn btn-primary mt-2">Start Shopping</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
