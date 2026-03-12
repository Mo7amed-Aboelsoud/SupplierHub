<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SupplierHub | Connect & Grow</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-color: #0d6efd; --secondary-color: #6c757d; }
        body { font-family: 'Poppins', sans-serif; background-color: #fff; }
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #003d99 100%);
            color: white;
            padding: 100px 0;
            border-radius: 0 0 50px 50px;
        }
        .feature-card {
            border: none;
            border-radius: 20px;
            transition: 0.3s;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .feature-card:hover { transform: translateY(-10px); }
        .btn-custom { border-radius: 50px; padding: 12px 30px; font-weight: 600; }
        .navbar-brand { font-weight: 800; letter-spacing: 1px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-cubes me-2"></i> SupplierHub</a>
            <div class="ms-auto">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-custom shadow-sm">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-custom me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-custom">Join Now</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero-section text-center">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">The Smartest Way to <br><span class="text-info">Supply Your Restaurant</span></h1>
            <p class="lead mb-5 opacity-75">Connect with top suppliers, manage orders, and grow your business in one place.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('shop') }}" class="btn btn-info btn-lg btn-custom text-white shadow">
                    <i class="fas fa-shopping-cart me-2"></i> Browse Marketplace
                </a>
                @guest
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg btn-custom">
                    Become a Supplier
                </a>
                @endguest
            </div>
        </div>
    </header>

    <section class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose SupplierHub?</h2>
            <p class="text-muted">Tailored solutions for both Suppliers and Restaurants</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="mb-4 text-primary"><i class="fas fa-truck fa-3x"></i></div>
                    <h4 class="fw-bold">For Suppliers</h4>
                    <p class="text-muted">List your products, manage inventory, and receive orders directly from local restaurants.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card border-primary">
                    <div class="mb-4 text-primary"><i class="fas fa-utensils fa-3x"></i></div>
                    <h4 class="fw-bold">For Restaurants</h4>
                    <p class="text-muted">Easy ordering system, real-time status updates, and a wide variety of fresh products.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="mb-4 text-primary"><i class="fas fa-shield-alt fa-3x"></i></div>
                    <h4 class="fw-bold">Secure Payments</h4>
                    <p class="text-muted">Transparent tracking and secure order management for peace of mind.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-light py-4 border-top">
        <div class="container text-center text-muted">
            <p class="mb-0">&copy; 2026 SupplierHub. All rights reserved. Made with ❤️ for Food Industry.</p>
        </div>
    </footer>

</body>
</html>
