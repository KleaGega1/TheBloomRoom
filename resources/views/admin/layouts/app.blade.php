<!-- App Blade for Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/icofont/icofont.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="d-lg-none">
                <button class="btn btn-dark d-flex justify-content-center align-items-center mt-2 ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                    <i class="icofont icofont-navigation-menu fs-4"></i>
                </button>
                <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Admin Dashboard</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body p-0">
                        <div class="d-flex flex-column align-items-start px-3 pt-2 min-vh-100">
                            <ul class="nav nav-pills flex-column mb-auto w-100">
                                <li class="nav-item mb-2">
                                    <a href="/admin" class="nav-link text-white">
                                        <i class="icofont icofont-dashboard fs-5"></i> <span class="ms-2">Dashboard</span>
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#submenu1Mobile" data-bs-toggle="collapse" class="nav-link text-white">
                                        <i class="icofont icofont-food-basket fs-5"></i> <span class="ms-2">Flowers</span>
                                    </a>
                                    <div class="collapse" id="submenu1Mobile">
                                        <ul class="nav flex-column ms-3">
                                            <li class="nav-item">
                                                <a href="/admin/flowers" class="nav-link text-white py-1">All Flowers</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/admin/flowers/create" class="nav-link text-white py-1">Add Flowers</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="#submenu2Mobile" data-bs-toggle="collapse" class="nav-link text-white">
                                        <i class="icofont icofont-slack fs-5"></i> <span class="ms-2">Categories</span>
                                    </a>
                                    <div class="collapse" id="submenu2Mobile">
                                        <ul class="nav flex-column ms-3">
                                            <li class="nav-item">
                                                <a href="/admin/categories" class="nav-link text-white py-1">All Categories</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="/admin/orders" class="nav-link text-white">
                                        <i class="icofont icofont-basket fs-5"></i> <span class="ms-2">Orders</span>
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="/admin/users" class="nav-link text-white">
                                        <i class="icofont icofont-users fs-5"></i> <span class="ms-2">Users</span>
                                    </a>
                                </li>
                            </ul>
                            <hr class="w-100">
                            <div class="dropdown pb-4 w-100">
                                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUserMobile" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="mx-1">{{get_logged_in_user()->name}}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="/logout/" method="POST" class="m-0">
                                            <button type="submit" class="list-group-item list-group-item-action text-danger w-100 text-start">
                                                <i class="icofont-logout me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto col-lg-3 col-xl-2 px-sm-2 px-0 bg-dark d-none d-lg-block">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/admin" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5">Admin Dashboard</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                        <li class="nav-item w-100 mb-2">
                            <a href="/admin" class="nav-link text-white">
                                <i class="icofont icofont-dashboard fs-5"></i> <span class="ms-2">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item w-100 mb-2">
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link text-white">
                                <i class="icofont icofont-food-basket fs-5"></i> <span class="ms-2">Flowers</span>
                            </a>
                            <div class="collapse" id="submenu1">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a href="/admin/products" class="nav-link text-white py-1">All Flowers</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/admin/products/create" class="nav-link text-white py-1">Add Flowers</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item w-100 mb-2">
                            <a href="#submenu2" data-bs-toggle="collapse" class="nav-link text-white">
                                <i class="icofont icofont-slack fs-5"></i> <span class="ms-2">Categories</span>
                            </a>
                            <div class="collapse" id="submenu2">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a href="/admin/categories" class="nav-link text-white py-1">All Categories</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item w-100 mb-2">
                            <a href="/admin/orders" class="nav-link text-white">
                                <i class="icofont icofont-basket fs-5"></i> <span class="ms-2">Orders</span>
                            </a>
                        </li>
                        <li class="nav-item w-100 mb-2">
                            <a href="/admin/users" class="nav-link text-white">
                                <i class="icofont icofont-users fs-5"></i> <span class="ms-2">Users</span>
                            </a>
                        </li>
                    </ul>
                    <hr class="w-100">
                    <div class="dropdown pb-4 w-100">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUserDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="mx-1">{{get_logged_in_user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="/logout/" method="POST" class="m-0">
                                    <button type="submit" class="list-group-item list-group-item-action text-danger w-100 text-start">
                                        <i class="icofont-logout me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 rounded">
                    <div class="container-fluid">
                        <span class="navbar-brand d-lg-none">Admin Dashboard</span>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <span class="nav-link">Welcome, {{get_logged_in_user()->name}}!</span>
                                </li>
                            </ul>
                            <div class="d-flex">
                                <a href="/" class="btn btn-outline-primary" target="_blank">View Site</a>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <div class="container-fluid px-0">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>