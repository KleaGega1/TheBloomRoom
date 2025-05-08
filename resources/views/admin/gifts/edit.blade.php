@extends('admin.layouts.app')

@section('title', 'Edit Gift')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Gift</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/gifts">Gifts</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    @include('admin.layouts.messages')

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Gifts: {{ $gift->name }}
        </div>
        <div class="card-body">
            <form action="/admin/gifts/{{ $gift->id }}/update/" method="POST" enctype="multipart/form-data">
                 <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Gift Name*</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $gift->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Gift Price*</label>
                        <input type="text" class="form-control" id="price" name="price" value="{{ $gift->price }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="quantity" class="form-label">Gift Quantity*</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" value="{{ $gift->quantity }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="occasion" class="form-label">Gift Occasion*</label>
                        <input type="text" class="form-control" id="occasion" name="occasion" value="{{ $gift->occasion }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="size" class="form-label">Gift Size*</label>
                        <input type="text" class="form-control" id="size" name="size" value="{{ $gift->size }}" >
                    </div>
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category*</label>   
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $gift->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Gift Image</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*">
                    <div class="form-text">Leave empty to keep the current image</div>
        @if(isset($gift->image_path) && $gift->image_path)
        <div class="mt-2">
            <label>Current Image:</label>
            <div class="mt-1">
                <img src="/{{ $gift->image_path }}" alt="{{ $gift->name }}" class="img-thumbnail" style="max-width: 150px;">
            </div>
        </div>
        @endif
    </div>
</div>

    <div class="row mb-3">
        <div class="col-12">
            <label for="description" class="form-label">Description*</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ $gift->description }}</textarea>
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="/admin/gifts" class="btn btn-secondary">Cancel</a>
    </div>
    </form>
    </div>
    </div>
</div>
@endsection
