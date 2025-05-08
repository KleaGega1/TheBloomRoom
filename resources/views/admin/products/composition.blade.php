@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Bouquet Composition</h1>


    <form action="{{ '/admin/products/composition/update/' . $bouquet->id }}" method="POST">
        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
    <div class="mb-3">
        <label for="bouquet_name" class="form-label">Bouquet Name</label>
        <input type="text" id="bouquet_name" class="form-control" value="{{ $bouquet->name }}" disabled>
    </div>
        <div class="mb-3">
            <h4>Flower Selection</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Flower</th>
                        <th>Image</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($flowers as $flower)
                        <tr>
                            <td>{{ $flower->name }}</td>
                            <td>
                                @if($flower->image_path )
                                    <img src="/{{ $flower->image_path }}" alt="{{ $flower->name }}" class="img-thumbnail" style="width: 80px;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>
                                <input type="number" name="flower[{{ $flower->id }}]" value="{{ $composition[$flower->id] ?? 0 }}" class="form-control" min="0" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Update Composition</button>
    </form>
    <a href="{{ url('/admin/products') }}" class="btn btn-secondary mt-3">Back to Products</a>
</div>
@endsection
