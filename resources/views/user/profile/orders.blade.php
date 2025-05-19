@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">My Orders</h2>
    @if(count($orders) === 0)
        <div class="alert alert-info">You have not placed any orders yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle shadow-sm rounded-3 overflow-hidden">
                <thead class="table-danger text-dark">
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Items</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="fw-bold">{{ $order->ref_code }}</td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td><span class="badge bg-primary">{{ ucfirst($order->status) }}</span></td>
                            <td class="fw-bold text-success">${{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($order->items as $item)
                                        <div class="d-flex align-items-center border rounded-3 p-2 bg-light" style="min-width:180px;">
                                            <img src="/{{ $item->product_id ? $item->product->image_path : ($item->gift ? $item->gift->image_path : 'images/products/default.png') }}" alt="{{ $item->product_id ? $item->product->name : ($item->gift ? $item->gift->name : 'Product') }}" class="rounded me-2" style="width:48px; height:48px; object-fit:cover;">
                                            <div>
                                                <div class="fw-semibold small">{{ $item->product_id ? $item->product->name : ($item->gift ? $item->gift->name : 'Product') }}</div>
                                                <div class="text-muted small">x{{ $item->quantity }} (${{ number_format($item->unit_price, 2) }})</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <a href="/profile/orders/{{ $order->id }}" class="btn btn-outline-primary btn-sm">View Order Details</a>
                                @if(in_array($order->status, ['unpaid','paid']) && (time() - strtotime($order->created_at) <= 3600))
                                    <form action="/profile/orders/{{ $order->id }}/cancel" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                                        <button type="submit" class="btn btn-danger btn-sm ms-1 cancel-order-btn" data-order-id="{{ $order->id }}">Cancel Order</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection 