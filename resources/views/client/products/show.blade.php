@extends('client.layouts.app')
@section('title', $product->name)
@section('content')
@include('admin.layouts.messages')
@php use Illuminate\Support\Str; @endphp

<div class="container py-5">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="row g-0">
            <div class="col-md-6">
                <div class="position-relative">
                    <div style="height: 500px;">
                        <img src="/{{ $product->image_path }}" alt="{{ $product->name }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                    </div>
                    @if($product->is_bouquet)
                    <span class="position-absolute top-0 end-0 bg-info text-white px-3 py-1 m-3 rounded-pill fw-semibold">
                        <i class="fas fa-flower me-1"></i> Bouquet Arrangement
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="fw-bold mb-3">{{ $product->name }}</h1>

                    <div class="mb-4">
                        @if($product->quantity <= 0)
                            <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">Out of Stock</span>
                        @elseif($product->quantity <= 5)
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fs-6">Low Stock ({{ $product->quantity }} left)</span>
                        @else
                            <span class="badge bg-success rounded-pill px-3 py-2 fs-6">In Stock</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h2 class="text-danger fw-bold fs-2">${{ number_format($product->price, 2) }}</h2>
                    </div>

                    <div class="product-attributes mb-4">
                        <div class="row">
                            @if($product->color)
                            <div class="col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper me-2">
                                        <i class="fas fa-palette fs-5 text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Color</small>
                                        <span>{{ $product->color }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($product->length)
                            <div class="col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper me-2">
                                        <i class="fas fa-ruler-vertical fs-5 text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Stem Length</small>
                                        <span>{{ $product->length }} cm</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($product->occasion)
                            <div class="col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper me-2">
                                        <i class="fas fa-gift fs-5 text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Perfect For</small>
                                        <span>{{ $product->occasion }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper me-2">
                                        <i class="fas fa-tag fs-5 text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Category</small>
                                        <span>{{ $product->category ? $product->category->name : 'No Category' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-description mb-4">
                        <h4 class="fw-semibold mb-3">Description</h4>
                        <div class="description-content lh-lg">
                            {!! $product->description !!}
                        </div>
                    </div>

                    @if($product->is_bouquet)
                    <div class="bouquet-composition mb-4">
                        <h4 class="fw-semibold mb-3">Bouquet Composition</h4>
                        <div class="composition-content">
                            <div class="list-group list-group-flush rounded-3 border">
                            @php
                                $bouquetFlowers = \App\Models\BouquetFlower::query()
                                    ->where('bouquet_id', $product->id)
                                    ->join('products', 'bouquet_flowers.flower_id', '=', 'products.id')
                                    ->select('products.name', 'products.color', 'bouquet_flowers.quantity')
                                    ->get();
                            @endphp
                            @forelse($bouquetFlowers as $flower)
                                <div class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                    <div>
                                        <span class="fw-medium">{{ $flower->name }}</span>
                                        @if($flower->color)
                                        <small class="text-muted d-block">{{ $flower->color }}</small>
                                        @endif
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $flower->quantity }} stem(s)</span>
                                </div>
                            @empty
                                <div class="list-group-item text-center py-3">No composition details available</div>
                            @endforelse
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mt-4">
                        @if($product->quantity > 0)
                        <form action="/cart/add" method="POST" >
                            <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                            <input type="hidden" name="item_id" value="{{ $product->id }}">
                            <input type="hidden" name="item_type" value="product">
                            <div class="row g-3">
                               <div class="mb-3">
                                    <label class="form-label small text-muted">Quantity:</label>
                                    <div class="d-flex align-items-center">
                                         <button type="button" class="btn btn-sm btn-light rounded-circle decrease-quantity" style="width: 32px; height: 32px;">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    <input type="number" class="form-control form-control-sm mx-2 text-center border-0 bg-light quantity-input" 
                                        name="quantity" value="1" min="1" max="{{ $product->quantity }}" style="width: 50px;">
                                    <button type="button" class="btn btn-sm btn-light rounded-circle increase-quantity" style="width: 32px; height: 32px;">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-3 w-100 shadow-sm">
                                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </form>
                        @else
                        <button class="btn btn-secondary rounded-pill px-4 py-3 w-100" disabled>
                            <i class="fas fa-ban me-2"></i> Out of Stock
                        </button>
                        <p class="text-muted mt-2 text-center">
                            <small>This item is currently out of stock. Please check back later.</small>
                        </p>
                        @endif
                    </div>

                </div>

                    <div class="mt-0 text-center">
                        <small class="text-muted">SKU: {{ $product->sku }}</small>
                    </div>
            </div>
            </div>
        </div>


        <!-- Display Product Reviews -->
        <div class="product-reviews mt-5">
            <h4 class="fw-semibold mb-3">Reviews</h4>

            <div class="d-flex align-items-center mb-3">
                <span class="fw-bold me-2 fs-5">{{ number_format($averageRating, 1) }}</span>

                <div class="text-warning me-2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($averageRating))
                            <i class="fas fa-star"></i>
                        @elseif ($i - $averageRating < 1)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>

                <span class="text-muted" style="font-size: 13px;">{{ $reviewCount }} {{ Str::plural('rating', $reviewCount) }}</span>
            </div>

            @if ($product->reviews->count() > 0)
                <div id="review-container">
                    @foreach ($product->reviews as $index => $review)
                        <div class="review mb-4 {{ $index >= 3 ? 'd-none extra-review' : '' }}">
                            <div class="rating text-warning">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($review->rating))
                                        <i class="fas fa-star"></i>
                                    @elseif ($i - $review->rating < 1)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            @if($review->photo)
                                <div class="mb-2">
                                    <img src="/{{ $review->photo }}" alt="Review photo" style="max-width:120px; max-height:120px; border-radius:8px;">
                                </div>
                            @endif
                            <p class="mb-0">{{ $review->comment }}</p>
                            <small class="text-muted d-block" style="font-size: 13px;">
                                {{ $review->user->name }} {{ $review->user->surname }}, {{ $review->created_at->format('j F Y') }}
                            </small>
                        </div>
                    @endforeach
                </div>

                @if ($product->reviews->count() > 3)
                    <button id="read-more-btn" class="btn btn-link p-0 mt-0">Read all reviews</button>
                @endif
            @else
                <p>No reviews yet for this product.</p>
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const button = document.getElementById('read-more-btn');
                if (button) {
                    button.addEventListener('click', function () {
                        document.querySelectorAll('.extra-review').forEach(el => el.classList.remove('d-none'));
                        button.style.display = 'none';
                    });
                }
            });
        </script>


        <div class="leave-review mt-5">
            <h4 class="fw-semibold mb-3">Leave a Review</h4>

            @if (isset($_SESSION['user_id']))
                @php
                    $user_id = $_SESSION['user_id'];
                    $delivered_orders = \App\Models\Order::where('user_id', $user_id)
                        ->where('status', 'delivered')
                        ->whereHas('items', function($query) use ($product) {
                            $query->where('product_id', $product->id);
                        })
                        ->get();
                @endphp

                @if($delivered_orders->count() > 0)
                    <style>
                        .star-rating i {
                            font-size: 24px;
                            color: #ccc;
                            cursor: pointer;
                            transition: color 0.2s;
                        }

                        .star-rating i.hover,
                        .star-rating i.selected {
                            color: #ffc107; 
                        }
                    </style>

                    <form action="/review/submit" method="POST" class="border rounded-3 p-4 shadow-sm" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?? ''; ?>">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <input type="hidden" name="rating" id="rating-value" required>
                        <input type="hidden" name="type" value="product">
                        <div class="mb-3">
                            <label for="review_photo" class="form-label">Upload Photo (optional):</label>
                            <input type="file" name="review_photo" id="review_photo" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rating:</label>
                            <div class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" data-value="{{ $i }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Add a comment:</label>
                            <textarea name="comment" id="comment" rows="4" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4">Submit Review</button>
                    </form>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const stars = document.querySelectorAll('.star-rating i');
                            const ratingInput = document.getElementById('rating-value');

                            let selectedRating = 0;

                            stars.forEach((star, index) => {
                                // Hover effect
                                star.addEventListener('mouseover', () => {
                                    stars.forEach((s, i) => {
                                        s.classList.toggle('hover', i <= index);
                                    });
                                });

                                star.addEventListener('mouseout', () => {
                                    stars.forEach((s, i) => {
                                        s.classList.remove('hover');
                                        s.classList.toggle('selected', i < selectedRating);
                                    });
                                });

                                // Click event to set rating
                                star.addEventListener('click', () => {
                                    selectedRating = parseInt(star.getAttribute('data-value'));
                                    ratingInput.value = selectedRating;

                                    stars.forEach((s, i) => {
                                        s.classList.remove('selected');
                                        if (i < selectedRating) {
                                            s.classList.add('selected');
                                        }
                                    });
                                });
                            });
                        });
                    </script>
                @else
                    <div class="alert alert-info">
                        You can only review items from orders that have been delivered. Purchase and receive this item to leave a review.
                    </div>
                @endif
            @else
                <div class="alert alert-warning">
                    You must be logged in to leave a review. <a href="/login" class="alert-link">Login here</a>.
                </div>
            @endif
        </div>
            @if (!empty($similarProducts) && count($similarProducts) > 0)
                <div class="similar-products mt-5">
                <h3 class="fw-bold mb-4">You May Also Like</h3>
                    <div class="row g-4">
                        @foreach($similarProducts as $similarProduct)
                            @if($similarProduct->id != $product->id)
                                    @include('client.products.product-card', ['product' => $similarProduct])
                            @endif
                        @endforeach
                    </div>
                </div>
        @endif
    </div>
</div>

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

