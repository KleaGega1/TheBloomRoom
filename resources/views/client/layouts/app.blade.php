<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ \App\Core\CSRFToken::_token() }}">
    <title>@yield('title', 'Your Website')</title>
    <!-- CSS and other head elements -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @yield('styles')
</head>
<body>
    <!-- Include the header -->
    @include('client.layouts.header')
    
    <!-- Main content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Include the footer -->
    @include('client.layouts.footer')
    
    <!-- JavaScript files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    
    <!-- Remove Cart Item Modal -->
    <div class="modal fade" id="removeCartItemModal" tabindex="-1" aria-labelledby="removeCartItemModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="removeCartItemModalLabel">Remove Item</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <p class="mb-0">Are you sure you want to remove this item from your cart?</p>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">No</button>
            <button type="button" class="btn btn-danger px-4" id="confirmRemoveCartItemBtn">Yes, Remove</button>
          </div>
        </div>
      </div>
    </div>
    <script>
    let removeCartForm = null;
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.remove-cart-item-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                removeCartForm = btn.closest('form');
                var modal = new bootstrap.Modal(document.getElementById('removeCartItemModal'));
                modal.show();
            });
        });
        var confirmBtn = document.getElementById('confirmRemoveCartItemBtn');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                if (removeCartForm) {
                    removeCartForm.submit();
                }
            });
        }
    });
    </script>
</body>
</html>