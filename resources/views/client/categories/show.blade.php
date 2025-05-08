@extends('client.layouts.app')

@section('content')
<div class="container py-5">

<div class="row g-3">
    @forelse($products as $product)
            @include('client.products.product-card', ['product' => $product])
    @empty
            <p>No products found in this category.</p>
    @endforelse
</div>

    <div class="row g-3 mt-4">
        @forelse ($gifts as $gift)
                @include('client.gifts.gift-card', ['gift' => $gift])
        @empty
         <p>No gifts found in this category.</p> 
        @endforelse
    </div>
</div>
@endsection