@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">All Orders</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Items</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->ref_code }}</td>
                        <td>{{ $order->user->name ?? 'User #'.$order->user_id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            <form action="/admin/orders/{{ $order->id }}/update-status" method="POST" class="d-inline">
                                <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="unpaid" {{ $order->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>${{ number_format($order->total_price, 2) }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($order->items as $item)
                                    <div class="d-flex align-items-center border rounded-3 p-2 bg-light" style="min-width:180px;">
                                        <img src="/{{ $item->product_id ? $item->product->image_path : ($item->gift ? $item->gift->image_path : 'images/products/default.png') }}" alt="{{ $item->product_id ? $item->product->name : ($item->gift ? $item->gift->name : 'Product') }}" class="rounded me-2" style="width:40px; height:40px; object-fit:cover;">
                                        <div>
                                            <div class="fw-semibold small">{{ $item->product_id ? $item->product->name : ($item->gift ? $item->gift->name : 'Product') }}</div>
                                            <div class="text-muted small">x{{ $item->quantity }} (${{ number_format($item->unit_price, 2) }})</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="text-uppercase">{{ $order->payment_method }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 