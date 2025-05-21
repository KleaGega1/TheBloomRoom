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

            <!-- Name and Surname -->
            <div class="row mb-3">
              <div class="col-12 col-sm-6 mb-3">
                <label for="name" class="form-label fw-bold text-dark">First Name:</label>
                <input type="text" id="name" name="name" class="form-control shadow-sm" placeholder="Enter your first name">
                <small id="error-name" class="text-danger d-none"></small>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="surname" class="form-label fw-bold text-dark">Last Name:</label>
                <input type="text" id="surname" name="surname" class="form-control shadow-sm" placeholder="Enter your last name">
                <small id="error-surname" class="text-danger d-none"></small>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="address" class="form-label fw-bold text-dark">Address:</label>
                <input type="text" id="address" name="address" class="form-control shadow-sm" placeholder="Enter your address">
                <small id="error-address" class="text-danger d-none"></small>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="city" class="form-label fw-bold text-dark">City:</label>
                <input type="text" id="city" name="city" class="form-control shadow-sm" placeholder="Enter your city">
                <small id="error-city" class="text-danger d-none"></small>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="postal_code" class="form-label fw-bold text-dark">Postal Code:</label>
                <input type="text" id="postal_code" name="postal_code" class="form-control shadow-sm" placeholder="Enter your postal code">
                <small id="error-postal_code" class="text-danger d-none"></small>
              </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label fw-bold text-dark">Email:</label>
              <input type="email" id="email" name="email" class="form-control shadow-sm" placeholder="Enter your email">
              <small id="error-email" class="text-danger d-none"></small>
            </div>

            <!-- Password and Confirm -->
            <div class="row mb-3">
              <div class="col-12 col-sm-6 mb-3">
                <label for="password" class="form-label fw-bold text-dark">Password:</label>
                <input type="password" id="password" name="password" class="form-control shadow-sm" placeholder="Enter password" minlength="6">
                <small id="error-password" class="text-danger d-none"></small>
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="confirm_password" class="form-label fw-bold text-dark">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control shadow-sm" placeholder="Confirm password">
                <small id="error-confirm_password" class="text-danger d-none"></small>
              </div>
            </div>

            <!-- Phone Number -->
            <div class="mb-3">
              <label for="telephone" class="form-label fw-bold text-dark">Phone Number:</label>
              <input type="text" id="telephone" name="telephone" class="form-control shadow-sm" placeholder="Enter your phone number">
              <small id="error-telephone" class="text-danger d-none"></small>
            </div>

            <!-- Profile Image -->
            <div class="mb-4">
              <label for="profile_image" class="form-label fw-bold text-dark">Profile Image:</label>
              <input type="file" id="profile_image" name="profile_image" class="form-control shadow-sm" accept="image/*">
              <small id="error-profile_image" class="text-danger d-none"></small>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
              <button type="submit" class="btn btn-danger shadow-sm">Register</button>
            </div>

            <!-- Login Redirect -->
            <div class="text-center mt-3">
              <p class="small text-muted">Already have an account? <a href="/login" class="text-decoration-none text-danger fw-bold">Login here</a></p>
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

    form.addEventListener('submit', function (event) {
        let isValid = true;
        
        // Clear previous errors
        const errorFields = document.querySelectorAll('small[id^="error-"]');
        errorFields.forEach(field => {
            field.textContent = '';
            field.classList.add('d-none');
        });

        // List of fields to validate
        const fields = ['name', 'surname', 'address', 'city', 'postal_code', 'email', 'password', 'confirm_password', 'telephone'];
        fields.forEach(function (fieldName) {
            const input = document.getElementById(fieldName);
            const errorField = document.getElementById('error-' + fieldName);
            if (!input.value.trim()) {
                errorField.textContent = 'This field is required';
                errorField.classList.remove('d-none');
                isValid = false;
            }
        });

        // Email pattern check
        const emailInput = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput.value && !emailRegex.test(emailInput.value.trim())) {
            const errorField = document.getElementById('error-email');
            errorField.textContent = 'Please enter a valid email address';
            errorField.classList.remove('d-none');
            isValid = false;
        }

        // Password length check
        const passwordInput = document.getElementById('password');
        if (passwordInput.value && passwordInput.value.length < 6) {
            const errorField = document.getElementById('error-password');
            errorField.textContent = 'Password must be at least 6 characters';
            errorField.classList.remove('d-none');
            isValid = false;
        }

        // Confirm Password match check
        const confirmPasswordInput = document.getElementById('confirm_password');
        if (passwordInput.value !== confirmPasswordInput.value) {
            const errorField = document.getElementById('error-confirm_password');
            errorField.textContent = 'Passwords do not match';
            errorField.classList.remove('d-none');
            isValid = false;
        }

        // Basic phone number validation
        const telephoneInput = document.getElementById('telephone');
        const phoneRegex = /^[\d\s()+-]{7,}$/;
        if (telephoneInput.value && !phoneRegex.test(telephoneInput.value.trim())) {
            const errorField = document.getElementById('error-telephone');
            errorField.textContent = 'Please enter a valid phone number';
            errorField.classList.remove('d-none');
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    // Remove error message on input
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function () {
            const errorField = document.getElementById('error-' + this.id);
            if (errorField) {
                errorField.textContent = '';
                errorField.classList.add('d-none');
            }
        });
    });
});
</script>

@endsection
