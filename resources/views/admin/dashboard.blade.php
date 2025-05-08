@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Dashboard</h1>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</div>

<div class="row mb-4">
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Gifts</h6>
                    </div>
                    <div>
                        <i class="icofont icofont-flower fs-1"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="/admin/gifts/" class="text-white text-decoration-none">View details <i class="icofont icofont-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Products(Flower|Bouquet)</h6>
                    </div>
                    <div>
                        <i class="icofont icofont-flower fs-1"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="/admin/products" class="text-white text-decoration-none">View details <i class="icofont icofont-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Orders</h6>
                    </div>
                    <div>
                        <i class="icofont icofont-cart fs-1"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="/admin/products/bouquets" class="text-white text-decoration-none">View details <i class="icofont icofont-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Users</h6>
                    </div>
                    <div>
                        <i class="icofont icofont-users-alt-5 fs-1"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ url('/admin/users') }}" class="text-white text-decoration-none">View details <i class="icofont icofont-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
