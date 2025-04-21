@extends('client.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forgot Password</div>

                <div class="card-body">
                @include('admin.layouts.messages')

                    <form method="POST" action="{{ url('/forgot-password') }}">
                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                        
                        <div class="form-group mb-3">
                            <label for="email">Email Address</label>
                            <input id="email" type="email" class="form-control" name="email" required autofocus>
                            <small class="form-text text-muted">Enter the email address you registered with, and we'll send you a link to reset your password.</small>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                Send Password Reset Link
                            </button>
                            <a href="{{ url('/login') }}" class="btn btn-link">
                                Back to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection