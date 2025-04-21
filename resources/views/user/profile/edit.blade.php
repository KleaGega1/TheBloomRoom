@extends('user.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container my-4">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-semibold text-danger">
                <i class="icofont-edit text-danger me-2"></i> Edit Profile
            </h4>
            <a href="/profile" class="btn btn-outline-danger btn-sm">
                <i class="icofont-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>
        <div class="card-body p-4">
            @include('general.layouts.messages')

            <div class="alert alert-info d-flex align-items-center mb-4">
                <i class="icofont-info-circle me-2 fs-5"></i>
                <span>Update your personal information below.</span>
            </div>

            <form action="/profile/{{ $user->id }}/update" method="post">
                <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold small text-muted">
                            Name
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="icofont-user text-danger"></i>
                            </span>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="surname" class="form-label fw-bold small text-muted">
                            Surname
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="icofont-user-alt-7 text-danger"></i>
                            </span>
                            <input type="text" id="surname" name="surname" class="form-control" value="{{ $user->surname }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold small text-muted">
                            Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="icofont-ui-email text-dark"></i>
                            </span>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="telephone" class="form-label fw-bold small text-muted">
                            Phone Number
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="icofont-ui-touch-phone text-dark"></i>
                            </span>
                            <input type="text" id="telephone" name="telephone" class="form-control" value="{{ $user->telephone }}">
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-start">
                        <button type="submit" class="btn btn-danger me-2 px-4">
                            <i class="icofont-save me-1"></i> Save Changes
                        </button>
                        <a href="/profile" class="btn btn-outline-secondary px-4">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
