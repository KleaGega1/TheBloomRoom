<!-- User profile page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/fonts/icofont/icofont.min.css">
    <title>@yield('title')</title>
</head>

<body class="bg-light">
    <div class="container-fluid py-3">
        <div class="row g-3">
            <div class="col-lg-3 col-md-4 d-none d-md-block">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-danger text-white text-center py-4">
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <?php if(!empty($user->profile_image)): ?>
                            <img src="<?php echo $user->profile_image; ?>" alt="<?php echo $user->username; ?>" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <i class="icofont-user-alt-7 text-primary" style="font-size: 2.5rem;"></i>
                        <?php endif; ?>
                    </div>
                        <h5 class="mb-0">{{ \App\Core\Session::get('user_name') }}</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="/profile" class="list-group-item list-group-item-action">
                            <i class="icofont-dashboard me-2"></i> Dashboard
                        </a>
                        <a href="/profile/{{ $user->id }}/edit" class="list-group-item list-group-item-action">
                            <i class="icofont-user me-2"></i> Edit Profile
                        </a>
                        <a href="/profile/{{ $user->id }}/edit/password" class="list-group-item list-group-item-action">
                            <i class="icofont-key me-2"></i> Change Password
                        </a>
                        <form action="/logout/" method="POST" class="m-0">
                            <button type="submit" class="list-group-item list-group-item-action text-danger w-100 text-start">
                                <i class="icofont-logout me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-12 d-md-none mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="/" class="btn btn-outline-primary btn-sm">
                        <i class="icofont-home"></i> Home
                    </a>
                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                        <i class="icofont-navigation-menu"></i> Menu
                    </button>
                </div>
            </div>
            
            <div class="col-lg-9 col-md-8 col-12">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title">{{ \App\Core\Session::get('user_name') }}</h5>
            <button type="button" class="btn-close text-reset bg-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="list-group list-group-flush">
                <a href="/profile/{{ $user->id }}" class="list-group-item list-group-item-action">
                    <i class="icofont-dashboard me-2"></i> Dashboard
                </a>
                <a href="/profile/{{ $user->id }}/edit" class="list-group-item list-group-item-action">
                    <i class="icofont-user me-2"></i> Edit Profile
                </a>
                <a href="/profile/{{ $user->id }}/edit/password" class="list-group-item list-group-item-action">
                    <i class="icofont-key me-2"></i> Change Password
                </a>
                <form action="/logout/" method="POST" class="m-0">
                    <button type="submit" class="list-group-item list-group-item-action text-danger w-100 text-start">
                        <i class="icofont-logout me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>