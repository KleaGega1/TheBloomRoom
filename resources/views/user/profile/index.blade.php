<!-- Profile Information about user -->
@extends('user.layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">User Dashboard</h5>
        <a href="/" class="btn btn-outline-danger btn-sm">
            <i class="icofont-home"></i> Back to Home
        </a>
    </div>
    <div class="card-body">
        @include('general.layouts.messages')
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Profile Information</h5>
                <a href="/profile/{{ $user->id }}/edit" class="btn btn-sm btn-outline-danger">
                    <i class="icofont-edit me-1"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <span class="bg-light p-2 rounded-circle me-3">
                                <i class="icofont-user text-black"></i>
                            </span>
                            <div>
                                <small class="text-muted">Name</small>
                                <p class="mb-0 fw-medium">{{ $user->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <span class="bg-light p-2 rounded-circle me-3">
                                <i class="icofont-user text-black"></i>
                            </span>
                            <div>
                                <small class="text-muted">Surname</small>
                                <p class="mb-0 fw-medium">{{ $user->surname }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <span class="bg-light p-2 rounded-circle me-3">
                                <i class="icofont-ui-email text-black"></i>
                            </span>
                            <div>
                                <small class="text-muted">Email Address</small>
                                <p class="mb-0 fw-medium">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <span class="bg-light p-2 rounded-circle me-3">
                                <i class="icofont-phone text-black"></i>
                            </span>
                            <div>
                                <small class="text-muted">Phone number</small>
                                <p class="mb-0 fw-medium">{{ $user->telephone }}</p>
                            </div>
                        </div>
                    </div>
                    
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection