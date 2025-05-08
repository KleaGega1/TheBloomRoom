<!-- Edit users view in admin -->
```blade
@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('content')

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h2 class="display-5 fw-normal mb-2">Edit User</h2>
            <p class="text-muted">Update user account information</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4 p-md-5 text-sm">
                    @include('admin.layouts.messages')
                    <form action="/admin/users/{{ $user->id }}/update/" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control form-control-lg border-0 bg-light" value="{{ $user->name }}" required>
                            <div class="form-text">User's complete name</div>
                        </div>
                        <div class="mb-4">
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" name="surname" class="form-control border-0 bg-light" value="{{ $user->surname }}" required>
                            <div class="form-text">Unique surname for login</div>
                        </div>
                        <div class="mb-4">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-select border-0 bg-light" required>
                                <option @if ($user->role == 'user') selected @endif value="user">User</option>
                                <option @if ($user->role == 'admin') selected @endif value="admin">Admin</option>
                            </select>
                            <div class="form-text">User access level in the system</div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3">Update User</button>
                            <a href="/admin/users" class="btn btn-link text-muted">Cancel and return to users</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
