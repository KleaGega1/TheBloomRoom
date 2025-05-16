@extends('client.layouts.app')
@section('title', $gift->name)
@section('content')
@include('admin.layouts.messages')
@php use Illuminate\Support\Str; @endphp


<div class="container py-5">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'] ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

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
                                <input type="hidden" name="item_id" value="{{ $gift->id }}">
                                <input type="hidden" name="item_type" value="gift">
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

                        @if ($gift->reviews->count() > 0)
                            <div id="review-container">
                                @foreach ($gift->reviews as $index => $review)
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
                                        <p class="mb-0">{{ $review->comment }}</p>
                                        <small class="text-muted d-block" style="font-size: 13px;">
                                            {{ $review->user->name }} {{ $review->user->surname }}, {{ $review->created_at->format('j F Y') }}
                                        </small>
                                    </div>
                                @endforeach
                            </div>

                            @if ($gift->reviews->count() > 3)
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
            <form action="/review/submit" method="POST" class="border rounded-3 p-4 shadow-sm">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?? ''; ?>">
                <input type="hidden" name="gift_id" value="{{ $gift->id }}">
                @if (isset($_SESSION['user_id']))
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                @else
                    <div class="alert alert-warning">
                        You must be logged in to leave a review. <a href="/login" class="alert-link">Login here</a>.
                    </div>
                @endif
                <input type="hidden" name="rating" id="rating-value" required>
                <input type="hidden" name="type" value="gift">
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
                @if (isset($_SESSION['user_id']))
                        <button type="submit" class="btn btn-primary px-4">Submit Review</button>
                    @else
                        <button type="button" class="btn btn-secondary px-4" disabled>Login to Submit Review</button>
                @endif            
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