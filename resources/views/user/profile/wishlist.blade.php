@extends('user.layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h2 class="mb-0">My Wishlist</h2>
    </div>
    <div class="card-body">
        @if ($wishlistItems->isEmpty())
            <p>Your wishlist is empty.</p>
        @else
            <div class="row g-3">
                @foreach ($wishlistItems as $item)
                    @include('client.products.product-card', ['product' => $item->product])
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.productId;
            
            try {
                const response = await fetch('/wishlist/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ product_id: productId })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update heart icon
                    const heartIcon = this.querySelector('i');
                    heartIcon.className = data.in_wishlist 
                        ? 'fas fa-heart text-danger'
                        : 'far fa-heart';
                    
                    // Show message
                    alert(data.message);
                    
                    // If removed from wishlist, remove the card
                    if (!data.in_wishlist) {
                        this.closest('.col-md-4').remove();
                    }
                } else {
                    alert(data.message || 'Failed to update wishlist');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while updating wishlist');
            }
        });
    });
});
</script>
@endpush
@endsection 