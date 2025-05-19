@extends('client.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
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

            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Delivery Information</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Recipient Name</label>
                        <input type="text" class="form-control" value="{{ $user->name }} {{ $user->surname }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" value="{{ $user->telephone }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Address</label>
                        <textarea class="form-control" rows="3" readonly>{{ $user->address }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Date</label>
                        <input type="text" class="form-control" value="{{ date('F j, Y', strtotime('+2 days')) }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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
                    <form action="/checkout/process" method="POST">
                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    Cash on Delivery (COD)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">
                                    PayPal
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 