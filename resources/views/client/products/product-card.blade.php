<div class="col-12 col-md-4 mb-4 product-card-container">
    <div class="card border-0 h-100 rounded-4 shadow-sm product-card position-relative overflow-hidden">
        <button class="btn position-absolute end-0 top-0 mt-2 me-2 z-index-5 bg-white bg-opacity-75 rounded-circle p-2 border-0 wishlist-btn"
                data-product-id="{{ $product->id }}"
                title="{{ $product->is_in_wishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                style="z-index: 10;">
            <i class="{{ $product->is_in_wishlist ? 'fas fa-heart text-danger' : 'far fa-heart' }} fs-5"></i>
        </button>
        <div class="bg-white p-3 rounded-top-4 d-flex justify-content-center align-items-center image-container">
            <img src="/{{ $product->image_path }}" 
                    alt="{{ $product->name }}" 
                    class="img-fluid rounded-3 shadow-sm product-image" 
                    style="max-width: 90%; max-height: 90%; object-fit: contain; transition: transform 0.4s ease;">
        </div>
        <div class="card-body pt-3 pb-4 px-3">
            @if($product->is_bouquet)
                <span class="badge bg-light text-secondary mb-2 fw-normal">Bouquet</span>
            @else
                <span class="badge bg-light text-secondary mb-2 fw-normal">Single Flower</span>
            @endif
            <h5 class="fw-semibold mb-1 lh-sm">{{ $product->name }}</h5>
            <div class="d-flex align-items-center mb-2">
                <span class="fw-bold text-dark">{{ number_format($product->price, 0) }} $</span>
            </div>
            @php
                $reviews = $product->reviews ?? collect();
                $averageRating = $reviews->avg('rating') ?? 0;
                $reviewCount = $reviews->count();
            @endphp



            <div class="d-flex align-items-center mb-2">
                <span class="fw-semibold me-1">{{ number_format($averageRating, 1) }}</span>
                <div class="text-warning me-2">
                    <i class="fas fa-star"></i>
                </div>
                <span class="text-muted small">({{ $reviewCount }})</span>
            </div>


            @if($product->occasion)
                <div class="d-flex align-items-center mb-2">
                    <span class="text-muted">Occasion: </span>
                    <span class="ms-1 fw-medium">{{ $product->occasion }}</span>
                </div>
            @endif
            <div class="d-flex align-items-center">
                <span class="text-muted small me-2">Earliest Delivery</span>
            </div>
            <a href="/products/{{ $product->id }}" class="see-details-btn">See Details</a>
            @if (strpos($_SERVER['REQUEST_URI'], '/profile/wishlist') !== false)
                <button class="btn btn-outline-danger btn-sm mt-2 wishlist-btn w-100" data-product-id="{{ $product->id }}">
                    <i class="fas fa-heart me-1"></i> Remove from Wishlist
                </button>
            @endif
        </div>
    </div>
</div>

<style>
    .image-container {
        width: 100%;
        height: 240px; 
        overflow: hidden;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    .product-card .product-image {
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .wishlist-btn:hover {
        background-color: rgba(255, 255, 255, 0.9) !important;
    }

    .wishlist-btn i.fas.text-danger {
        animation: heartBeat 0.3s ease-in-out;
    }

    @keyframes heartBeat {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    /* Remove from Wishlist button custom styles */
    .btn-outline-danger.wishlist-btn.w-100:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
        border-color: #dc3545 !important;
    }
    .btn-outline-danger.wishlist-btn.w-100:active {
        background-color: #b52a37 !important;
        color: #fff !important;
        border-color: #b52a37 !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productCards = document.querySelectorAll('.product-card');
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow');
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow');
            this.classList.add('shadow-sm');
            this.style.transform = 'translateY(0)';
        });
    });

    wishlistButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Prevent double click
            if (this.disabled) return;
            this.disabled = true;

            const productId = this.dataset.productId;
            const heartIcon = this.querySelector('i');

            try {
                const response = await fetch('/wishlist/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                const data = await response.json();

                if (data.success) {
                    heartIcon.className = data.in_wishlist 
                        ? 'fas fa-heart text-danger fs-5'
                        : 'far fa-heart fs-5';

                    showCustomAlert(
                        data.in_wishlist ? 'Item added to wishlist!' : 'Item removed from wishlist',
                        data.in_wishlist ? 'success' : 'danger'
                    );

                    // Only remove the card if we are on the wishlist page
                    if (!data.in_wishlist && window.location.pathname === '/profile/wishlist') {
                        this.closest('.col-md-4').remove();
                    }
                } else {
                    showCustomAlert(data.message || 'Failed to update wishlist', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showCustomAlert('An error occurred while updating wishlist', 'danger');
            } finally {
                this.disabled = false;
            }
        });
    });
});
</script>