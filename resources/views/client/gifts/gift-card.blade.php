<div class="col-12 col-md-4 mb-4 gift-card ">
    <div class="card border-0 h-100 rounded-4 shadow-sm product-card position-relative overflow-hidden">
        <button class="btn position-absolute end-0 top-0 m-2 z-index-5 bg-white bg-opacity-75 rounded-circle p-2 border-0 wishlist-btn">
            <i class="far fa-heart fs-5"></i>
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
            <div class="d-flex align-items-center mb-2">
                <span class="fw-semibold me-1">{{ number_format($gift->rating ?? 4.8, 1) }}</span>
                <div class="text-warning me-2">
                    <i class="fas fa-star"></i>
                </div>
                <span class="text-muted small">({{ $product->reviews_count ?? '163' }})</span>
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
            <a href="/gifts/{{ $gift->id }}" class="see-details-btn">See Details</a>
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
</style>
<script>
        document.addEventListener('DOMContentLoaded', function() {
        const wishlistButtons = document.querySelectorAll('.product-card .btn');
     wishlistButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const heartIcon = this.querySelector('i');
                if (heartIcon.classList.contains('far')) {
                    heartIcon.classList.remove('far');
                    heartIcon.classList.add('fas', 'text-danger');
                } else {
                    heartIcon.classList.remove('fas', 'text-danger');
                    heartIcon.classList.add('far');
                }
            });
        });
    });
</script>