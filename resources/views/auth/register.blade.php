@extends('client.layouts.app')
@section('title', 'Register')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-dark" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                        </svg>
                        <h2 class="mt-3 mb-2 text-danger">Create Account</h2>
                        <p class="text-muted small">Please provide your details to register</p>
                    </div>

                    @include('client.layouts.messages')

                    <form method="POST" enctype="multipart/form-data" action="/register/" id="registerForm" novalidate>
                        <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">

                        <!-- Name and Surname Fields -->
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                                <label for="name" class="form-label fw-bold text-dark">First Name:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-dark" viewBox="0 0 16 16">
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="name" name="name" class="form-control shadow-sm" placeholder="Enter your first name" required>
                                </div>
                                <div class="invalid-feedback">Please enter your first name</div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="surname" class="form-label fw-bold text-dark">Last Name:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-dark" viewBox="0 0 16 16">
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="surname" name="surname" class="form-control shadow-sm" placeholder="Enter your last name" required>
                                </div>
                                <div class="invalid-feedback">Please enter your last name</div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="address" class="form-label fw-bold text-dark">Address:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-dark" viewBox="0 0 16 16">
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="address" name="address" class="form-control shadow-sm" placeholder="Enter your last name" required>
                                </div>
                                <div class="invalid-feedback">Please enter your address</div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="city" class="form-label fw-bold text-dark">City:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-dark" viewBox="0 0 16 16">
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="city" name="city" class="form-control shadow-sm" placeholder="Enter your last name" required>
                                </div>
                                <div class="invalid-feedback">Please enter your city</div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <label for="postal_code" class="form-label fw-bold text-dark">Postal Code:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-dark" viewBox="0 0 16 16">
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                    </span>
                                    <input type="text" id="postal_code" name="postal_code" class="form-control shadow-sm" placeholder="Enter your last name" required>
                                </div>
                                <div class="invalid-feedback">Please enter your postal code</div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-dark">Email:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-dark" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    </svg>
                                </span>
                                <input type="email" id="email" name="email" class="form-control shadow-sm" placeholder="Enter your email" required>
                                <div class="invalid-feedback">Please enter a valid email</div>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="flex-fill me-2">
                                <label for="password" class="form-label fw-bold text-dark">Password:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-dark" viewBox="0 0 16 16">
                                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                        </svg>
                                    </span>
                                    <input type="password" id="password" name="password" class="form-control shadow-sm" placeholder="Enter password" minlength="6" required>
                                    <div class="invalid-feedback">Password must be at least 6 characters</div>
                                </div>
                            </div>

                            <div class="flex-fill ms-2">
                                <label for="confirm_password" class="form-label fw-bold text-dark">Confirm Password:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-dark" viewBox="0 0 16 16">
                                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                        </svg>
                                    </span>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control shadow-sm" placeholder="Confirm password" required>
                                    <div class="invalid-feedback">Passwords do not match</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label fw-bold text-dark">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone text-dark" viewBox="0 0 16 16">
                                        <path d="M3.654 1.328a.678.678 0 0 1 .58-.326h2.094c.266 0 .516.166.603.418l.683 1.99a.678.678 0 0 1-.15.69l-1.2 1.2a11.72 11.72 0 0 0 4.516 4.516l1.2-1.2a.678.678 0 0 1 .69-.15l1.99.683a.678.678 0 0 1 .418.603v2.094a.678.678 0 0 1-.326.58c-.443.296-1.05.737-1.512.94-.645.284-1.482.268-2.311-.112a16.978 16.978 0 0 1-6.223-6.223c-.38-.829-.396-1.666-.112-2.311.203-.462.644-1.07.94-1.512z"/>
                                    </svg>
                                </span>
                                <input id="telephone" name="telephone" class="form-control shadow-sm" placeholder="Enter your phone number" required>
                                <div class="invalid-feedback">Please provide a valid phone number</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="profile_image" class="form-label fw-bold text-dark">Profile Image</label>
                            <input type="file" name="profile_image" accept="image/*" id="profile_image" class="form-control shadow-sm">
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-danger py-2">Register</button>
                        </div>

                        <div class="text-center">
                            <p class="small text-muted mb-0">Already have an account? <a href="/login" class="text-danger fw-bold">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const email = document.getElementById('email');
    const telephone = document.getElementById('telephone');

    form.addEventListener('submit', function (event) {
        let isValid = true;
        form.querySelectorAll('input[required]').forEach(function (input) {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.value && !emailRegex.test(email.value)) {
            email.classList.add('is-invalid');
            isValid = false;
        }
        if (password.value.length < 6) {
            password.classList.add('is-invalid');
            isValid = false;
        }
        if (confirmPassword.value !== password.value) {
            confirmPassword.classList.add('is-invalid');
            isValid = false;
        }
        const phoneRegex = /^[\d\s()+-]{7,}$/;
        if (telephone.value && !phoneRegex.test(telephone.value)) {
            telephone.classList.add('is-invalid');
            isValid = false;
        }
        if (!isValid) {
            event.preventDefault();
        }
    });
    form.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function () {
            this.classList.remove('is-invalid');
            if (this.id === 'password' || this.id === 'confirm_password') {
                confirmPassword.classList.toggle('is-invalid', password.value !== confirmPassword.value);
            }
        });
    });
});
</script>

@endsection
