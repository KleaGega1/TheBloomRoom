@extends('user.layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="container my-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-danger fw-semibold">
                <i class="icofont-key me-2 text-danger"></i> Change Password
            </h4>
            <a href="/profile" class="btn btn-outline-danger btn-sm">
                <i class="icofont-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>
        <div class="card-body p-4">
            @include('general.layouts.messages')

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <form action="/profile/{{ $user->id }}/update/password" method="post">
                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">

                        <div class="mb-3">
                            <label for="oldPassword" class="form-label fw-bold small text-muted">
                                Current Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="icofont-lock text-secondary"></i>
                                </span>
                                <input type="password" id="oldPassword" name="oldPassword" class="form-control" placeholder="Enter your current password" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newPassword" class="form-label fw-bold small text-muted">
                                New Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="icofont-lock text-secondary"></i>
                                </span>
                                <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="Enter your new password" required>
                            </div>
                            <small class="text-muted ms-1">Password must be at least 6 characters long.</small>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-danger">
                                <i class="icofont-refresh me-1"></i> Update Password
                            </button>
                            <a href="/profile/{{ $user->id }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
