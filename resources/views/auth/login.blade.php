<!-- Login View -->
@extends('client.layouts.app')

@section('title', 'Login')

@section('content')
<div class="container my-5">
    @include('admin.layouts.messages')
    <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-black" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                        </svg>
                        <h2 class="mt-3 mb-1 text-danger">Welcome Back</h2>
                        <p class="text-muted small">Sign in to continue</p>
                    </div>
                    @include('client.layouts.messages')
                    <form id="loginForm" action="/login/" method="post" novalidate>
                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">

                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold">Email:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-black" viewBox="0 0 16 16">
                                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                                    </svg>
                                </span>
                                <input type="text" id="email" name="email" class="form-control" placeholder="Enter email" autofocus>
                            </div>
                            <small class="text-danger d-block mt-1" id="emailError"></small>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label small fw-bold">Password:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-black" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                    </svg>
                                </span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                            </div>
                            <small class="text-danger d-block mt-1" id="passwordError"></small>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-danger py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                                </svg>
                                Sign In
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="small text-muted mb-0">Don't have an account? <a href="/register" class="text-danger fw-bold">Register</a></p>
                        </div>
                        <div class="text-center">
                            <a href="/forgot-password" class="small text-danger">
                                <!-- SVG omitted for brevity -->
                                Forgot your password?
                            </a>
                        </div>
                    </form>

                    <!-- JavaScript validation -->
                    <script>
                        document.getElementById('loginForm').addEventListener('submit', function (e) {
                            const email = document.getElementById('email').value.trim();
                            const password = document.getElementById('password').value.trim();

                            let valid = true;

                            // Reset error messages
                            document.getElementById('emailError').textContent = '';
                            document.getElementById('passwordError').textContent = '';

                            if (email === '') {
                                document.getElementById('emailError').textContent = 'Email is required.';
                                valid = false;
                            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                                document.getElementById('emailError').textContent = 'Enter a valid email address.';
                                valid = false;
                            }

                            if (password === '') {
                                document.getElementById('passwordError').textContent = 'Password is required.';
                                valid = false;
                            } else if (password.length < 6) {
                                document.getElementById('passwordError').textContent = 'Password must be at least 6 characters.';
                                valid = false;
                            }

                            if (!valid) {
                                e.preventDefault();
                            }
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
