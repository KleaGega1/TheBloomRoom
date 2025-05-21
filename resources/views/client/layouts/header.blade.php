<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Bloom Room — Flower Shopping</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-danger bg-opacity-10 py-5 text-center">
        <div class="container">
            <h1 class="display-5 text-danger fw-bold mb-3">The Bloom Room</h1>
            <p class="lead mb-4 text-danger">Your Favorite Flower Shop</p>
            <form class="d-flex justify-content-center" action="/products">
                <div class="input-group mb-3" style="max-width: 500px;">
                    <input type="search" class="form-control rounded-start shadow-sm border-0" placeholder="Search for flowers..." aria-label="Search" name="key">
                    <button class="btn btn-danger" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            <div class="mt-4">
                <span class="badge bg-danger bg-opacity-25 text-danger me-2 py-2 px-3 fw-normal">🌷 Free Delivery</span>
                <span class="badge bg-danger bg-opacity-25 text-danger me-2 py-2 px-3 fw-normal">🌹 Fresh Flowers</span>
                <span class="badge bg-danger bg-opacity-25 text-danger py-2 px-3 fw-normal">🌸 Same Day Delivery</span>
            </div>
        </div>
    </header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand text-danger fw-bold" href="/">
                <i class="fas fa-flower-daffodil me-2"></i>The Bloom Room
            </a>
            <button class="navbar-toggler border-danger" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item px-2">
                        <a class="nav-link text-dark fw-semibold" href="/">Home</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link text-dark fw-semibold" href="/products/">Shop</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link text-dark fw-semibold" href="/about">About</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link text-dark fw-semibold" href="/contact">Contact</a>
                    </li>
                </ul>
            <div class="d-flex align-items-center">
                <a href="/cart" class="btn rounded-circle p-2 position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle shadow-sm"
                        style="
                            background-color: #dc3545;
                            color: white;
                            border-radius: 80%;
                            font-size: 0.65rem;
                            padding: 0.2em 0.45em;
                            transform: translate(-80%, -30%);
                        ">
                        {{ count(user_cart_items()) }}
                    </span>
                </a>

                <a href="{{ is_logged_in() ? (is_admin() ? '/admin' : '/profile') : '/login' }}" class="btn rounded-circle p-2 position-relative">
                    <i class="fa fa-user"></i>
                </a>
            </div>



            </div>
        </div>
    </nav>


@php
    $mainCategories = \App\Models\Category::where('parent_id', 0)->get();

    $subcategories = \App\Models\Category::where('parent_id', '!=', 0)->get()->groupBy('parent_id');
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm w-100 mt-1">
        <div class="container-fluid">
            <button class="navbar-toggler border-danger mx-3" type="button" data-bs-toggle="collapse" data-bs-target="#categoriesNavbar" aria-controls="categoriesNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <span class="ms-2 text-danger">Shop by Category</span>
            </button>
            <div class="collapse navbar-collapse" id="categoriesNavbar">
                <ul class="navbar-nav w-100 d-flex justify-content-around px-4">
                    @foreach ($mainCategories as $mainCategory)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold text-bold text-black px-3 " href="#" id="navbarDropdown_{{ $mainCategory->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $mainCategory->name }}
                            </a>
                            @if (isset($subcategories[$mainCategory->id]))
                                <ul class="dropdown-menu shadow-sm rounded-3 border-light" aria-labelledby="navbarDropdown_{{ $mainCategory->id }}">
                                    @foreach ($subcategories[$mainCategory->id] as $subcategory)
                                        <li>
                                            <a class="dropdown-item text-black" href="{{ url('/categories/' . $subcategory->slug) }}">
                                                {{ $subcategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>    <!-- Bootstrap JS -->
</body>
</html>