

@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="bg-light py-4 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold mb-0">Categories</h1>
                    <p class="text-muted">Manage your product categories</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5">
        <div class="col-12 col-md-8 col-lg-6 mb-5 mx-auto">
            <form action="/admin/categories/store/" method="post" class="p-4 border rounded shadow-sm bg-light">
                <div class="form-group mb-3">
                    <label for="categoryName" class="form-label">Category Name:</label>
                    <input type="text" name="name" id="categoryName" placeholder="Enter category name" class="form-control rounded-0" required>
                </div>
                <div class="d-flex justify-content-between">
                    <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                    <input type="submit" value="Add New Category" class="btn btn-success rounded-0">
                </div>
            </form>
        </div>
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">Category Name</th>
                            <th class="py-3">Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="py-3 align-middle">
                                    <span class="fw-bold">{{ $category->name }}</span>
                                </td>
                                <td class="py-3 align-middle text-end">
                                    <div class="d-flex justify-content-end">
                                        <a href="/admin/categories/{{ $category->id }}/edit/" class="btn btn-sm btn-outline-primary me-2">
                                            Edit
                                        </a>
                                        <form action="/admin/categories/{{ $category->id }}/delete/" method="post">
                                            <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure , you want to delete this category?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if(count($categories) == 0)
                            <tr>
                                <td colspan="2" class="text-center py-5">
                                    <div class="py-5">
                                        <i class="bi bi-exclamation-circle display-6 text-muted mb-3"></i>
                                        <h5>No categories found</h5>
                                        <p class="text-muted">Try changing your search criteria or add a new category</p>
                                        <a href="/admin/categories/create" class="btn btn-primary mt-3">Add Category</a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {!! $links !!}
        </div>
    </div>

@endsection