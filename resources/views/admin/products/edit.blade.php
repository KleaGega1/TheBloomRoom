@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Product</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/products">Products</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    @include('admin.layouts.messages')

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Product: {{ $product->name }}
        </div>
        <div class="card-body">
            <form action="/admin/products/{{ $product->id }}/update/" method="POST" enctype="multipart/form-data">
                 <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name*</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sku" class="form-label">Product SKU*</label>
                        <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->sku }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Product Price*</label>
                        <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="quantity" class="form-label">Product Quantity*</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="occasion" class="form-label">Product Occasion*</label>
                        <input type="text" class="form-control" id="occasion" name="occasion" value="{{ $product->occasion }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="color" class="form-label">Product Color*</label>
                        <input type="text" class="form-control" id="color" name="color" value="{{ $product->color }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="length" class="form-label">Product Length*</label>
                        <input type="text" class="form-control" id="length" name="length" value="{{ $product->length }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category*</label>   
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="is_bouquet" class="form-label">Is Bouquet?</label>
                        <input type="checkbox" id="is_bouquet" name="is_bouquet" value="1" {{ $product->is_bouquet ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Product Image</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*">
                        <div class="form-text">Leave empty to keep current image</div>
                        
                        @if($product->image_path)
                        <div class="mt-2">
                            <label>Current Image:</label>
                            <div class="mt-1">
                                <img src="/{{ $product->image_path }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="description" class="form-label">Description*</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required>{{ $product->description }}</textarea>
                    </div>
                </div>
                <div id="bouquetFields" style="{{ $product->is_bouquet ? '' : 'display: none;' }}">
                    <h4 class="mt-4">Bouquet Composition</h4>
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
                                            <img src="/{{ $flower->image_path }}" alt="{{ $flower->name }}" 
                                                 class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                            <span>{{ $flower->name }}</span>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="flower[{{ $flower->id }}]" 
                                                   value="{{ isset($bouquetFlowers[$flower->id]) ? $bouquetFlowers[$flower->id] : 0 }}" min="0">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="/admin/products" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
