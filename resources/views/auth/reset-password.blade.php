@extends('client.layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="container my-5">
    @include('admin.layouts.messages')
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-black" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                        <h2 class="mt-3 mb-1 text-danger">Reset Password</h2>
                        <p class="text-muted small">Enter your new password</p>
                    </div>

                    <form method="POST" action="{{ url('/reset-password') }}">
                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold">New Password:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-black" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2z"/>
                                        <path d="M3 9a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/>
                                    </svg>
                                </span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password" required>
                            </div>
                            <small class="form-text text-muted">Password must be at least 6 characters.</small>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="form-label small fw-bold">Confirm Password:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-black" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2z"/>
                                        <path d="M3 9a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/>
                                    </svg>
                                </span>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                    <path d="M3.5 8a.5.5 0 0 1 .5-.5h5.793l-2.147-2.146a.5.5 0 0 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 1 1-.708-.708L9.793 8.5H4a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                                Reset Password
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="/login" class="text-danger small">Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection