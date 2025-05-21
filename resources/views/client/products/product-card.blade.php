<div class="col-12 col-md-4 mb-4 product-card-container">
    <div class="card border-0 h-100 rounded-4 shadow-sm product-card position-relative overflow-hidden">
        <button class="btn position-absolute end-0 top-0 mt-2 me-2 z-index-5 bg-white bg-opacity-75 rounded-circle p-2 border-0 wishlist-btn"
                data-item-id="{{ $product->id }}"
                data-item-type="product"
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
           <div class="d-grid">
                <a href="/products/{{ $product->id }}" class="btn-see-details-minimal">
                    See Details <i class="fas fa-chevron-right ms-1 details-icon"></i>
                </a>
            </div>
            @if (strpos($_SERVER['REQUEST_URI'], '/profile/wishlist') !== false)
                <button class="btn btn-outline-danger btn-sm mt-2 wishlist-btn w-100" data-item-id="{{ $product->id }}" data-item-type="product">
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
      .btn-see-details-minimal {
        display: block;
        text-align: center;
        padding: 8px 0;
        color: #6c757d;
        font-weight: 500;
        border-top: 1px solid #e9ecef;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-top: 5px;
    }
    
    .btn-see-details-minimal:hover {
        color: #212529;
        background-color: #f8f9fa;
    }
    
    .btn-see-details-minimal .details-icon {
        font-size: 12px;
        transition: transform 0.2s ease;
    }
    
    .btn-see-details-minimal:hover .details-icon {
        transform: translateX(3px);
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
            if (this.disabled) return;
            this.disabled = true;
            const itemId = this.dataset.itemId;
            const itemType = this.dataset.itemType;
            const heartIcon = this.querySelector('i');
            try {
                const csrfToken = document.querySelector('meta[name=\'csrf-token\']').content;
                const response = await fetch('/wishlist/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        item_id: itemId,
                        item_type: itemType
                    })
                });
                const data = await response.json();
                if (data.success) {
                    heartIcon.className = data.in_wishlist 
                        ? 'fas fa-heart text-danger fs-5'
                        : 'far fa-heart fs-5';
                    // Show alert using Bootstrap alert
                    const alertDiv = document.createElement('div');
                    alertDiv.className = `alert alert-${data.in_wishlist ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
                    alertDiv.style.zIndex = '9999';
                    alertDiv.innerHTML = `
                        ${data.message}
                        <button type=\'button\' class=\'btn-close\' data-bs-dismiss=\'alert\' aria-label=\'Close\'></button>
                    `;
                    document.body.appendChild(alertDiv);
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 3000);
                    if (!data.in_wishlist && window.location.pathname === '/profile/wishlist') {
                        this.closest('.col-md-4').remove();
                    }
                } else {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
                    alertDiv.style.zIndex = '9999';
                    alertDiv.innerHTML = `
                        ${data.message || 'Failed to update wishlist'}
                        <button type=\'button\' class=\'btn-close\' data-bs-dismiss=\'alert\' aria-label=\'Close\'></button>
                    `;
                    document.body.appendChild(alertDiv);
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 3000);
                }
            } catch (error) {
                console.error('Error:', error);
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
                alertDiv.style.zIndex = '9999';
                alertDiv.innerHTML = `
                    An error occurred while updating wishlist
                    <button type=\'button\' class=\'btn-close\' data-bs-dismiss=\'alert\' aria-label=\'Close\'></button>
                `;
                document.body.appendChild(alertDiv);
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            } finally {
                this.disabled = false;
            }
        });
    });
});
</script>