@extends('client.layouts.app')

@section('title', 'About Us')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-5 text-center">About The Bloom Room</h2>
        <div class="row align-items-center gy-4">
            <div class="col-md-6">
                <img src="/images/products/flowers.jpg" alt="Our Story" class="img-fluid rounded shadow-sm" style="max-height: 450px;">
            </div>
            <div class="col-md-6 ps-md-5">
                <p class="lead">The Bloom Room was born out of a passion for flowers and the joy they bring. We believe every bloom tells a story — of love, celebration, and connection.</p>
                <p>Our mission is to make it easy for you to send beautiful, fresh flowers and curated gifts to your loved ones. Whether it's a birthday, anniversary, or just a thoughtful surprise, we’re here to make every moment special.</p>
                <p>All our arrangements are hand-crafted with care, and we work with local growers to ensure freshness and sustainability.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h3 class="mb-4 text-center">What Sets Us Apart</h3>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded h-100 shadow-sm">
                    <i class="fas fa-seedling fa-2x mb-3 text-success"></i>
                    <h5>Locally Sourced</h5>
                    <p>We partner with local flower farms to bring you the freshest blooms with the lowest environmental impact.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded h-100 shadow-sm">
                    <i class="fas fa-heart fa-2x mb-3 text-danger"></i>
                    <h5>Handmade with Love</h5>
                    <p>Each arrangement is carefully crafted by our skilled florists to express just the right emotion.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded h-100 shadow-sm">
                    <i class="fas fa-gift fa-2x mb-3 text-primary"></i>
                    <h5>Gifts for Every Occasion</h5>
                    <p>From classic bouquets to customized gift baskets, we help you celebrate life’s meaningful moments.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
