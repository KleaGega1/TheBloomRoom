@extends('admin.layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Product</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="admin/products/index">Products</a></li>
        <li class="breadcrumb-item active">Add New</li>
    </ol>

    @include('admin.layouts.messages')

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus-circle me-1"></i>
            Product Information
        </div>
        <div class="card-body">
            <form action="/admin/products/store" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_bouquet" id="is_bouquet" value="1"
                                onchange="toggleBouquetFields(this.checked)">
                            <label class="form-check-label" for="is_bouquet">
                                This is a bouquet arrangement
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name*</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sku" class="form-label">SKU*</label>
                        <input type="text" class="form-control" id="sku" name="sku" required>
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
                        <label for="image" class="form-label">Product Image*</label>
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
                <div id="singleFlowerFields">
                    <h4 class="mt-4">Flower Attributes</h4>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="color" name="color">
                        </div>
                        <div class="col-md-4">
                            <label for="length" class="form-label">Stem Length (cm)</label>
                            <input type="number" class="form-control" id="length" name="length" min="0">
                        </div>
                        <div class="col-md-4">
                            <label for="occasion" class="form-label">Occasion</label>
                            <input type="text" class="form-control" id="occasion" name="occasion">
                        </div>
                    </div>
                </div>
                <div id="bouquetFields" style="display: none;">
                    <h4 class="mt-4">Bouquet Composition</h4>
                    <p class="text-muted">Select flowers and quantities to include in this bouquet</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Flower</th>
                                    <th style="width: 150px;">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($flowers as $flower)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="/{{ $flower->image_path }}" alt="{{ $flower->name }}"
                                                class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                            <span>{{ $flower->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="flowers[{{ $flower->id }}]" value="0" min="0">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <a href="/admin/products/" class="btn btn-secondary">Cancel</a>
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
