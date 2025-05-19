@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    <a href="/profile/orders" class="btn btn-outline-secondary mb-4"><i class="icofont-arrow-left"></i> Back to My Orders</a>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Order #{{ $order->ref_code }}</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="fw-bold">Order Date:</h6>
                    <p>{{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Status:</h6>
                    <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="fw-bold">Recipient:</h6>
                    <p>{{ $order->recipient_name }}<br>{{ $order->recipient_phone }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Delivery Address:</h6>
                    <p>{{ $order->delivery_address }}</p>
                    <h6 class="fw-bold mt-3">Delivery Date:</h6>
                    <p>{{ $order->delivery_date }}</p>
                </div>
            </div>
            <h5 class="fw-bold mt-4 mb-3">Order Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td><img src="/{{ $item->product_id ? $item->product->image_path : ($item->gift ? $item->gift->image_path : 'images/products/default.png') }}" alt="{{ $item->product_id ? $item->product->name : ($item->gift ? $item->gift->name : 'Product') }}" class="rounded" style="width:60px; height:60px; object-fit:cover;"></td>
                                <td>{{ $item->product_id ? $item->product->name : ($item->gift ? $item->gift->name : 'Product') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                <td class="fw-bold">${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <div class="bg-light p-3 rounded-3 shadow-sm">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Order Total:</span>
                        <span class="fw-bold text-success fs-5">${{ number_format($order->total_price, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Payment Method:</span>
                        <span class="text-uppercase">{{ $order->payment_method }}</span>
                    </div>
                </div>
            </div>
            @if(in_array($order->status, ['unpaid','paid']) && (time() - strtotime($order->created_at) <= 3600))
                <form action="/profile/orders/{{ $order->id }}/cancel" method="POST" class="mt-3">
                    <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                    <button type="submit" class="btn btn-danger cancel-order-btn" data-order-id="{{ $order->id }}">Cancel Order</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection 