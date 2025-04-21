<!-- Edit profile view of user  -->
@extends('user.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Profile</h5>
        <a href="/profile" class="btn btn-outline-primary btn-sm">
            <i class="icofont-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>
    <div class="card-body">
        @include('general.layouts.messages')
        <form action="/profile/{{ $user->id }}/update" method="post">
            <input type="hidden" name="csrf" value="{{ \App\Core\CSRFToken::_token() }}">
            <div class="row g-3">
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="icofont-info-circle"></i> Update your personal information below
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">
                            <span class="bg-light p-2 rounded-circle me-2">
                                <i class="icofont-user text-primary"></i>
                            </span>
                            Name
                        </label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="surname" class="form-label">
                            <span class="bg-light p-2 rounded-circle me-2 ">
                                <i class="icofont-user-alt-7 text-primary"></i>
                            </span>
                            Surname
                        </label>
                        <input type="text" id="surname" name="surname" class="form-control" value="{{ $user->surname }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">
                            <span class="bg-light p-2 rounded-circle me-2">
                                <i class="icofont-ui-email text-black"></i>
                            </span>
                            Email
                        </label>
                        <input type="text" id="email" name="email" class="form-control" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="telephone" class="form-label">
                            <span class="bg-light p-2 rounded-circle me-2">
                                <i class="icofont-ui-touch-phone text-black"></i>
                            </span>
                            Phone Number
                        </label>
                        <input type="text" id="telephone" name="telephone" class="form-control" value="{{ $user->telephone }}">
                    </div>
                </div>
               
                <div class="col-12 d-flex">
                    <button type="submit" class="btn btn-primary me-2">
                        Save Changes
                    </button>
                    <a href="/profile" class="btn btn-light">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection