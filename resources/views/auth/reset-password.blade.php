@extends('client.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reset Password</div>
                <div class="card-body">
                @include('admin.layouts.messages')

                    <form method="POST" action="{{ url('/reset-password') }}">
                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group mb-3">
                            <label for="password">New Password</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                            <small class="form-text text-muted">Password must be at least 6 characters long.</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="confirm_password">Confirm New Password</label>
                            <input id="confirm_password" type="password" class="form-control" name="confirm_password" required>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection