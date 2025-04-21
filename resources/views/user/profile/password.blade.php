
@extends('user.layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Change Password</h5>
        <a href="/profile/{{ $user->id }}" class="btn btn-outline-primary btn-sm">
            <i class="icofont-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>
    <div class="card-body">
        @include('general.layouts.messages')
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <form action="/profile/{{ $user->id }}/update/password" method="post">
                    <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">
                            <i class="icofont-key me-1 text-primary"></i> Current Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="icofont-lock"></i>
                            </span>
                            <input type="password" id="oldPassword" name="oldPassword" class="form-control" placeholder="Enter your current password">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="newPassword" class="form-label">
                            <i class="icofont-refresh me-1 text-primary"></i> New Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="icofont-lock"></i>
                            </span>
                            <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="Enter your new password">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            Update Password
                        </button>
                        <a href="/profile/{{ $user->id }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection