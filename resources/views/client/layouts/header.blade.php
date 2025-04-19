<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Bloom Room — Flower Shopping</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header class="bg-light py-5 text-center">
        <div class="container">
            <h1 class="display-4 text-danger mb-3">The Bloom Room</h1>
            <p class="lead mb-4">Your Favorite Flower Shop</p>
            <form class="d-flex justify-content-center">
                <div class="input-group w-50">
                    <input type="search" class="form-control rounded-pill border-0 shadow-sm" placeholder="Search for flowers..." aria-label="Search">
                    <button class="btn btn-danger rounded-pill" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand text-danger fw-bold" href="/">The Bloom Room</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item px-3">
                        <a class="nav-link text-dark" href="/">Home</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link text-dark" href="/shop">Shop</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link text-dark" href="/about">About</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link text-dark" href="/contact">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="{{ is_logged_in() ? (is_admin() ? '/admin' : '/profile') : '/login' }}" class="btn btn-light rounded-circle p-2 me-2">
                        <i class="fa fa-user"></i>
                    </a>
                    <a href="/cart" class="btn  rounded-circle p-2">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
