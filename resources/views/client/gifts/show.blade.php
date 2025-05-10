@extends('client.layouts.app')
@section('title', $gift->name)
@section('content')
@include('admin.layouts.messages')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm overflow-hidden mb-5">
                <div class="row g-0">
                    <div class="col-md-6 p-0 d-flex align-items-center justify-content-center">
                        <img src="/{{ $gift->image_path }}" alt="{{ $gift->name }}" class="img-fluid w-100 " style="height: 500px; object-fit: cover;">
                    </div>
                    <div class="col-md-6 bg-white">
                        <div class="card-body p-4">
                            <h2 class="fw-bold mb-2">{{ $gift->name }}</h2>
                            <h4 class="text-primary mb-3">${{ number_format($gift->price, 2) }}</h4>
                            
                            @if($gift->quantity <= 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($gift->quantity <= 5)
                                <span class="badge bg-warning text-dark">Only {{ $gift->quantity }} left</span>
                            @else
                                <span class="badge bg-success">In Stock</span>
                            @endif

                            <hr class="my-4">
                            
                            <div class="mb-4">
                                <div class="row mb-3">
                                    @if($gift->occasion)
                                    <div class="col-6">
                                        <small class="text-muted d-block">Perfect For</small>
                                        <span>{{ $gift->occasion }}</span>
                                    </div>
                                    @endif
                                    
                                    <div class="col-6">
                                        <small class="text-muted d-block">Category</small>
                                        <span>{{ $gift->category ? $gift->category->name : 'No Category' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="fw-semibold mb-2">Description</h5>
                                <div class="text-muted">
                                    {!! $gift->description !!}
                                </div>
                            </div>
                            @if($gift->quantity > 0)
                            <form action="/cart/add" method="POST" class="mt-4">
                                <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                                <input type="hidden" name="gift_id" value="{{ $gift->id }}">
                                
                                <div class="mb-3">
                                    <label class="form-label small text-muted">Quantity:</label>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-light rounded-circle decrease-quantity" style="width: 32px; height: 32px;">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="form-control form-control-sm mx-2 text-center border-0 bg-light quantity-input" 
                                               name="quantity" value="1" min="1" max="{{ $gift->quantity }}" style="width: 50px;">
                                        <button type="button" class="btn btn-sm btn-light rounded-circle increase-quantity" style="width: 32px; height: 32px;">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm">
                                    <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                </button>
                            </form>
                            @else
                            <div class="mt-4">
                                <button class="btn btn-secondary btn-lg w-100 rounded-pill" disabled>
                                    <i class="fas fa-times-circle me-2"></i> Out of Stock
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(count($similarGift) > 0)
                <div class="similar-products mt-5">
                    <h3 class="fw-bold mb-4">You May Also Like</h3>
                    <div class="row g-4">
                        @foreach($similarGift as $similar)
                            @if($similar->id != $gift->id)
                                    @include('client.gifts.gift-card', ['gift' => $similar])
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const decreaseBtn = document.querySelector('.decrease-quantity');
        const increaseBtn = document.querySelector('.increase-quantity');
        const quantityInput = document.querySelector('.quantity-input');
        
        if (decreaseBtn && increaseBtn && quantityInput) {
            decreaseBtn.addEventListener('click', function() {
                const value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });
            
            increaseBtn.addEventListener('click', function() {
                const value = parseInt(quantityInput.value);
                const max = parseInt(quantityInput.getAttribute('max'));
                if (value < max) {
                    quantityInput.value = value + 1;
                }
            });
        }
    });
</script>
@endsection