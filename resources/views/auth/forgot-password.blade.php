@extends('client.layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="container my-5">
    @include('admin.layouts.messages')
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-danger" viewBox="0 0 16 16">
                            <path d="M10.273 2.513l-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0z"/>
                        </svg>
                        <h2 class="mt-3 mb-1 text-danger">Reset Password</h2>
                        <p class="text-muted small">We'll send a reset link to your email</p>
                    </div>

                    <form method="POST" action="{{ url('/forgot-password') }}">
                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">

                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-black" viewBox="0 0 16 16">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1l-8 5-8-5V4z"/>
                                        <path d="M0 6.236l7.684 4.802a.5.5 0 0 0 .632 0L16 6.236V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6.236z"/>
                                    </svg>
                                </span>
                                <input id="email" type="email" name="email" class="form-control" placeholder="Enter your email" required autofocus>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-danger py-2">
                                Send Reset Link
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ url('/login') }}" class="text-danger small">Back to Login</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection