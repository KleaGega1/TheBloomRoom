@extends('client.layouts.app')

@section('title', 'Home')

@section('content')

<!-- Hero Banner -->
<section class="py-5 bg-danger text-white text-center d-flex align-items-center" 
    style="background-image: url('/images/products/peonies.webp'); background-size: cover; background-position: center; min-height: 300px;">
    <div class="container">
        <p class="lead" style="font-family: 'Palatino Linotype', serif; font-style: italic; font-size: 45px;">
            Welcome to the Bloom Room
        </p>
        <a href="/products" class="btn btn-danger btn-md mt-3 px-3" >
            Shop Now
        </a>
    </div>
</section>


<!-- Featured Categories Carousel -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-4">Explore Our Collections</h2>

        <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="row g-4 text-center">
                        <div class="col-md-4">
                            <div class="border p-4 rounded shadow-sm h-100">
                                <img src="/images/icons/rose.png" alt="Roses" class="mb-3" style="height: 70px;">
                                <h5>Romantic Roses</h5>
                                <p class="text-muted">A timeless symbol of love and passion.</p>
                                <a href="/categories/rose-bouquets" class="btn btn-outline-danger btn-sm mt-2">Browse Roses</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-4 rounded shadow-sm h-100">
                                <img src="/images/icons/tulip.png" alt="Tulips" class="mb-3" style="height: 70px;">
                                <h5>Trendy Tulips</h5>
                                <p class="text-muted">Elegant and fresh for every mood and moment.</p>
                                <a href="/categories/tulip-bouquets" class="btn btn-outline-danger btn-sm mt-2">Browse Tulips</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-4 rounded shadow-sm h-100">
                                <img src="/images/icons/gift-basket.png" alt="Gifts" class="mb-3" style="height: 70px;">
                                <h5>Gift Bundles</h5>
                                <p class="text-muted">More than flowers – make it a complete surprise!</p>
                                <a href="/categories/gift-baskets" class="btn btn-outline-danger btn-sm mt-2">Explore Gifts</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 (shto kategori te tjera këtu) -->
                <div class="carousel-item">
                    <div class="row g-4 text-center">
                        <div class="col-md-4">
                            <div class="border p-4 rounded shadow-sm h-100">
                                <img src="/images/icons/sunflower.png" alt="Sunflowers" class="mb-3" style="height: 70px;">
                                <h5>Sunny Sunflowers</h5>
                                <p class="text-muted">Brighten someone's day with sunshine.</p>
                                <a href="/categories/sunflower-bouquets" class="btn btn-outline-danger btn-sm mt-2">Shop Now</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-4 rounded shadow-sm h-100">
                                <img src="/images/icons/orchid.png" alt="Orchids" class="mb-3" style="height: 70px;">
                                <h5>Orchid Charm</h5>
                                <p class="text-muted">Exotic beauty with every petal.</p>
                                <a href="/categories/orchid-bouquets" class="btn btn-outline-danger btn-sm mt-2">Browse Orchids</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-4 rounded shadow-sm h-100">
                                <img src="/images/icons/plant.png" alt="Lilies" class="mb-3" style="height: 70px;">
                                <h5>Plants</h5>
                                <p class="text-muted">Add a touch of green to your home.</p>
                                <a href="/categories/plants" class="btn btn-outline-danger btn-sm mt-2">Explore Plants</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev"
                style="width: 50px; height: 50px; background-color: rgba(255,255,255,0.7); border-radius: 50%; top: 50%; left: -60px; transform: translateY(-50%);">
                <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1);"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next"
                style="width: 50px; height: 50px; background-color: rgba(255,255,255,0.7); border-radius: 50%; top: 50%; right: -60px; transform: translateY(-50%);">
                <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1);"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>
    </div>
</section>

<!-- About Section (unchanged) -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-md-6">
                <img src="/images/products/peonies-bg.jpg" alt="About Us" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6 ps-md-5">
                <h3>About The Bloom Room</h3>
                <p class="text-muted">We are passionate about flowers and the emotions they represent. From birthdays to weddings, we make every moment bloom with beauty. Every bouquet is crafted with care and delivered with a personal touch.</p>
                <a href="/about" class="btn btn-danger mt-3">Learn More</a>
            </div>
        </div>
    </div>
</section>

@endsection
