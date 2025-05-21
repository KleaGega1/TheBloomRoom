@extends('client.layouts.app')

@section('content')
<div class="container py-5">

<div class="row g-3">
    @forelse($products as $product)
            @include('client.products.product-card', ['product' => $product])
    @empty
    @endforelse
</div>

    <div class="row g-3 mt-2">
        @forelse ($gifts as $gift)
                @include('client.gifts.gift-card', ['gift' => $gift])
        @empty
        @endforelse
    </div>
</div>
@endsection