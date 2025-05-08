@extends('admin.layouts.app')

@section('title', 'Manage Gifts')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Gifts</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Gifts</li>
    </ol>

    @include('admin.layouts.messages')

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                All Gifts
            </div>
            <div>
                <a href="/admin/gifts/create" class="btn btn-primary">Add New Gift</a>
            </div>
        </div>
        <div class="card-body">
            <table id="giftsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gifts as $gift)
                    <tr>
                        <td>
                            @if($gift->image_path && file_exists($gift->image_path))
                                <img src="/{{ $gift->image_path }}" alt="{{ $gift->name }}" class="img-thumbnail" style="max-width: 80px;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $gift->name }}</td>
                        <td>{{ $gift->category ? $gift->category->name : 'No Category' }}</td>
                        <td>${{ number_format($gift->price, 2) }}</td>
                        <td>
                            @if($gift->quantity <= 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($gift->quantity <= 5)
                                <span class="badge bg-warning">Low Stock ({{ $gift->quantity }})</span>
                            @else
                                {{ $gift->quantity }}
                            @endif
                        </td>
                        <td>{{ $gift->size }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/admin/gifts/{{ $gift->id }}/edit/" class="btn btn-sm btn-outline-primary me-2">
                                    Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $gift->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                            <div class="modal fade" id="deleteModal{{ $gift->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="/admin/gifts/{{ $gift->id }}/delete/" method="POST" style="display: inline;">
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
        $('#giftsTable').DataTable({
            paging: false,
            info: false,
        });
    });
</script>
@endsection