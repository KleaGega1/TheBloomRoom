@extends('admin.layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Products</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Products</li>
    </ol>

    @include('admin.layouts.messages')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                All Products
            </div>
            <div>
                <a href="/admin/products/create" class="btn btn-primary">Add New Product</a>
            </div>
        </div>
        <div class="card-body">
            <table id="productsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            @if($product->image_path && file_exists($product->image_path))
                                <img src="/{{ $product->image_path }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 80px;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->category ? $product->category->name : 'No Category' }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->quantity <= 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($product->quantity <= 5)
                                <span class="badge bg-warning">Low Stock ({{ $product->quantity }})</span>
                            @else
                                {{ $product->quantity }}
                            @endif
                        </td>
                        <td>
                            @if($product->is_bouquet)
                                <span class="badge bg-info">Bouquet</span>
                            @else
                                <span class="badge bg-success">Single Flower</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/admin/products/{{ $product->id }}/edit/" class="btn btn-sm btn-outline-primary me-2">
                                    Edit
                                </a>
                                @if($product->is_bouquet)
                                <a href="/admin/products/composition/manage/{{ $product->id }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-list"></i> Composition
                                </a>
                                @endif
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete <strong>{{ $product->name }}</strong>?
                                            @if($product->is_bouquet)
                                            <p class="text-warning">This will also delete all bouquet composition data.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="/admin/products/{{ $product->id }}/delete/" method="POST" style="display: inline;">
                                                <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {!! $links !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#productsTable').DataTable({
            paging: false,
            info: false,
        });
    });
</script>
@endsection