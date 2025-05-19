@extends('client.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-black fw-bold">Your Shopping Cart</h1>
    @if(count($items) > 0)
        <div class="card shadow-sm rounded-3 border-0 overflow-hidden">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i> Cart Items</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Item</th>
                            <th scope="col">Type</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            @php
                                $itemData = $item->item;
                                $subtotal = $item->price * $item->quantity;
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $itemData->image_path }}" alt="{{ $itemData->name }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-3">
                                            <h6 class="mb-0">{{ $itemData->name }}</h6>
                                            <small class="text-muted">SKU: {{ $itemData->sku }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $item->product_id ? 'primary' : 'success' }} rounded-pill px-3 py-2">
                                        {{ $item->product_id ? 'Product' : 'Gift' }}
                                    </span>
                                </td>
                                <td><span class="fw-bold">${{ number_format($item->price, 2) }}</span></td>
                                <td>
                                    <form action="/cart/{{ $item->id }}/update" method="post" class="quantity-form d-flex align-items-center">
                                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <div class="input-group" style="width: 120px;">
                                            <button type="button" class="btn btn-outline-secondary btn-sm decrease-quantity">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $itemData->quantity }}" class="form-control text-center">
                                            <button type="button" class="btn btn-outline-secondary btn-sm increase-quantity">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary ms-2">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="fw-bold">${{ number_format($subtotal, 2) }}</td>
                                <td class="text-center">
                                    <form action="/cart/{{ $item->id }}/remove" method="POST" class="d-inline">
                                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                                        <button type="submit" class="btn btn-danger btn-sm rounded-circle remove-cart-item-btn" data-item-id="{{ $item->id }}" data-bs-toggle="tooltip" title="Remove item">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="4" class="text-end fw-bold fs-5 pe-4">Total:</td>
                            <td colspan="2" class="fw-bold fs-5">${{ number_format($total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="/products" class="btn btn-outline-secondary px-4 py-2">
                <i class="fas fa-arrow-left me-2"></i> Continue Shopping
            </a>
            <a href="/checkout" class="btn btn-success px-4 py-2">
                Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h3 class="text-muted">Your cart is empty</h3>
            <p class="text-muted">Add some items to your cart to continue shopping</p>
            <a href="/products" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag me-2"></i> Start Shopping
            </a>
        </div>
    @endif
</div>

<script>
    document.querySelectorAll('.increase-quantity').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input[name="quantity"]');
            const max = parseInt(input.getAttribute('max')) || 100;
            let current = parseInt(input.value) || 1;
            if (current < max) {
                input.value = current + 1;
            }
        });
    });

    document.querySelectorAll('.decrease-quantity').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input[name="quantity"]');
            let current = parseInt(input.value) || 1;
            if (current > 1) {
                input.value = current - 1;
            }
        });
    });
</script>
@endsection