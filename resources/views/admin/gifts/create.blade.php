@extends('admin.layouts.app')

@section('title', 'Add New Gift')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Gift</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="admin/gifts/index">Gifts</a></li>
        <li class="breadcrumb-item active">Add New</li>
    </ol>

    @include('admin.layouts.messages')

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus-circle me-1"></i>
            Gifts Information
        </div>
        <div class="card-body">
            <form action="/admin/gifts/store" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                <div class="row mb-3">
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Gift Name*</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                   
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price*</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="quantity" class="form-label">Quantity*</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label for="size" class="form-label">Size*</label>
                        <input type="text" class="form-control" id="size" name="size" >
                    </div>
                    <div class="col-md-6">
                        <label for="occasion" class="form-label">Occasion*</label>
                        <input type="text" class="form-control" id="occasion" name="occasion" min="0" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category*</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="image" class="form-label">Gift Image*</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                        <div class="form-text">Recommended size: 800x800 pixels</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="description" class="form-label">Description*</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <a href="/admin/gifts/" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleBouquetFields(isBouquet) {
        const singleFlowerFields = document.getElementById('singleFlowerFields');
        const bouquetFields = document.getElementById('bouquetFields');

        if (isBouquet) {
            singleFlowerFields.style.display = 'none';
            bouquetFields.style.display = 'block';
        } else {
            singleFlowerFields.style.display = 'block';
            bouquetFields.style.display = 'none';
        }
    }

    $(document).ready(function() {
        $('#description').summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']]
            ]
        });
    });
</script>
@endsection
