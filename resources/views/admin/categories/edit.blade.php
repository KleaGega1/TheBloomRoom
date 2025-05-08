@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
    <h1 class="text-center mt-4 mb-4">Edit Category: {{ $category->name }}</h1>
    <div class="container mt-5">
        <div class="col-12 col-md-8 col-lg-5 mb-5 mx-auto">
            @include('admin.layouts.messages')
            <form action="/admin/categories/{{ $category->id }}/update/" method="post" class="bg-white p-4 rounded shadow-sm">
                <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                <div class="form-group mb-4">
                    <label for="name" class="form-label">Category Name:</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" placeholder="Enter category name" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="/admin/categories" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Update Category</button>
                </div>
            </form>
        </div>
    </div>
@endsection