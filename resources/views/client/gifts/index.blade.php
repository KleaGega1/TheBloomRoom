@extends('client.layouts.app')

@section('title', 'Our Flowers & Bouquets')

@section('content')
<div class="container py-5">
    <div class="mb-5 d-flex justify-content-end">
    <form method="GET" action="{{ '/gifts' }}" class="d-inline-block">
                @if(isset($q) && !empty($q))
                    <input type="hidden" name="key" value="{{ $q }}">
                @endif
                <label for="sort" class="me-2 fw-semibold">Sort by price:</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="form-select d-inline-block w-auto">
                    <option value="">-- Select --</option>
                    <option value="asc" {{ $sort == 'asc' ? 'selected' : '' }}>Lowest to Highest</option>
                    <option value="desc" {{ $sort == 'desc' ? 'selected' : '' }}>Highest to Lowest</option>
                </select>
            </form>
    </div>
     <div class="row g-3">
        @forelse($gifts as $gift)
            @include('client.gifts.gift-card')
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center p-5 rounded-4 shadow-sm">
                    <i class="fas fa-info-circle fa-3x text-primary mb-3"></i>
                    <h4 class="fw-bold">No products found</h4>
                    <p class="text-muted">We couldn't find any products matching your criteria. Please try a different search or browse our categories.</p>
                </div>
            </div>
        @endforelse
    </div>
    <div class="pagination mt-4">
        {!! $links !!}
    </div>
</div>

@endsection

@section('styles')
<style>
    body {
        background-color: #fafafa;
    }

    h1, h4 {
        color: #2c3e50;
    }

    .form-label {
        color: #495057;
    }

    .form-select:focus, .btn:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .product-card {
        transition: transform 0.2s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-card:hover .btn-primary {
        background-color: #0056b3;
    }
</style>
@endsection
