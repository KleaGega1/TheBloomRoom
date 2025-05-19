@extends('client.layouts.app')

@section('content')
<div class="container py-5">
    <div class="alert alert-success text-center" style="background-color: #e6fff2; color: #218838; border-radius: 12px; border: 2px solid #b2f2d7; box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
        <h2 style="font-weight: bold;">Order placed!</h2>
        <p style="font-size: 1.1em;">Your order has been successfully placed. Thank you for shopping with us.</p>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Order Summary</h4>
        </div>
        <div class="card-body">
            @foreach($items as $item)
                <div class="d-flex mb-3">
                    <img src="/{{ $item->product_id ? $item->product->image_path : $item->gift->image_path }}" 
                         alt="{{ $item->product_id ? $item->product->name : $item->gift->name }}"
                         class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="ms-3">
                        <h5 class="mb-1">{{ $item->product_id ? $item->product->name : $item->gift->name }}</h5>
                        <p class="mb-1">Quantity: {{ $item->quantity }}</p>
                        <p class="mb-0">Price: ${{ number_format($item->price, 2) }}</p>
                    </div>
                    <div class="ms-auto">
                        <h5>${{ number_format($item->price * $item->quantity, 2) }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Delivery Information</h4>
        </div>
        <div class="card-body">
            <p><strong>Recipient Name:</strong> {{ $recipient_name }}</p>
            <p><strong>Phone Number:</strong> {{ $recipient_phone }}</p>
            <p><strong>Delivery Address:</strong> {{ $delivery_address }}</p>
            <p><strong>Delivery Date:</strong> {{ $delivery_date }}</p>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Payment Method</h4>
        </div>
        <div class="card-body">
            <p>{{ strtoupper($payment_method) }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Order Total</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <span>Subtotal</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span>Delivery Fee</span>
                <span>Free</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <strong>Total</strong>
                <strong>${{ number_format($total, 2) }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection 