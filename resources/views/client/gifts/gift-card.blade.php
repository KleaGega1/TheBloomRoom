<div class="col-12 col-md-4 mb-4 gift-card ">
    <div class="card border-0 h-100 rounded-4 shadow-sm product-card position-relative overflow-hidden">
        <button class="btn position-absolute end-0 top-0 m-2 z-index-5 bg-white bg-opacity-75 rounded-circle p-2 border-0 wishlist-btn"
                data-item-id="{{ $gift->id }}"
                data-item-type="gift"
                title="{{ $gift->is_in_wishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
            <i class="{{ $gift->is_in_wishlist ? 'fas fa-heart text-danger' : 'far fa-heart' }} fs-5"></i>
        </button>
        <div class="bg-white p-3 rounded-top-4 d-flex justify-content-center align-items-center image-container" style="height: 200px;">
            <img src="/{{ $gift->image_path }}" 
                 alt="{{ $gift->name }}" 
                 class="img-fluid rounded-3 shadow-sm product-image" 
                 style="max-width: 100%; max-height: 100%; object-fit: cover; transition: transform 0.4s ease;">
        </div>
        <div class="card-body pt-3 pb-4 px-3">
            <h5 class="fw-semibold mb-1 lh-sm">{{ $gift->name }}</h5>
            <div class="d-flex align-items-center mb-2">
                <span class="fw-bold text-dark">{{ number_format($gift->price, 0) }} $</span>
            </div>
            @php
                $reviews = $gift->reviews ?? collect();
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

            @if($gift->occasion)
                <div class="d-flex align-items-center mb-2">
                    <span class="text-muted">Occasion: </span>
                    <span class="ms-1 fw-medium">{{ $gift->occasion }}</span>
                </div>
            @endif
            <div class="d-flex align-items-center">
                <span class="text-muted small me-2">Earliest Delivery</span>
            </div>
           <div class="d-grid">
                <a href="/gifts/{{ $gift->id }}" class="btn-see-details-minimal">
                    See Details <i class="fas fa-chevron-right ms-1 details-icon"></i>
                </a>
            </div>
            @if (strpos($_SERVER['REQUEST_URI'], '/profile/wishlist') !== false)
                <button class="btn btn-outline-danger btn-sm mt-2 wishlist-btn w-100" data-item-id="{{ $gift->id }}" data-item-type="gift">
                    <i class="fas fa-heart me-1"></i> Remove from Wishlist
                </button>
            @endif
        </div>
    </div>
</div>

<style>
    .image-container {
        height: 200px;
        background-color: #f8f9fa;
        overflow: hidden;
        transition: background-color 0.3s ease;
    }

    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .wishlist-btn:hover {
        background-color: #f8d7da;
    }

    .wishlist-btn i.fas.text-danger {
        transition: color 0.3s ease;
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
    document.body.addEventListener('click', async function(e) {
        const button = e.target.closest('.wishlist-btn');
        if (!button) return;
                e.preventDefault();
                e.stopPropagation();
                
        if (button.disabled) return;
        button.disabled = true;

        const itemId = button.dataset.itemId;
        const itemType = button.dataset.itemType;
        const heartIcon = button.querySelector('i');
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
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
                if (heartIcon) {
                    heartIcon.className = data.in_wishlist 
                        ? 'fas fa-heart text-danger fs-5'
                        : 'far fa-heart fs-5';
                }
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${data.in_wishlist ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
                alertDiv.style.zIndex = '9999';
                alertDiv.innerHTML = `
                    ${data.message}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                `;
                document.body.appendChild(alertDiv);
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
                if (!data.in_wishlist && window.location.pathname === '/profile/wishlist') {
                    button.closest('.col-md-4, .gift-card, .product-card-container').remove();
                }
            } else {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
                alertDiv.style.zIndex = '9999';
                alertDiv.innerHTML = `
                    ${data.message || 'Failed to update wishlist'}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
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
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            `;
            document.body.appendChild(alertDiv);
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        } finally {
            button.disabled = false;
        }
        });
    });
</script>