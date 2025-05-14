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
                    @if ($item->product)
                        @include('client.products.product-card', ['product' => $item->product])
                    @elseif ($item->gift)
                        @include('client.gifts.gift-card', ['gift' => $item->gift])
                    @endif
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
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const itemId = this.dataset.itemId;
            const itemType = this.dataset.itemType;
            
            try {
                const response = await fetch('/wishlist/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ 
                        item_id: itemId,
                        item_type: itemType
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    if (!data.in_wishlist) {
                        this.closest('.col-md-4').remove();
                    }
                    showCustomAlert(data.message, data.in_wishlist ? 'success' : 'danger');
                } else {
                    showCustomAlert(data.message || 'Failed to update wishlist', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showCustomAlert('An error occurred while updating wishlist', 'danger');
            }
        });
    });
});
</script>
@endpush
@endsection 