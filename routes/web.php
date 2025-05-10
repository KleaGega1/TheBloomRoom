<?php
// All the routes for the website
$router->map('GET', '[/]?', 'HomeController@index');

# auth  routes
$router->map('GET', '/register[/]?', 'AuthController@register');
$router->map('POST', '/register/', 'AuthController@registerPost');
$router->map('GET', '/login[/]?', 'AuthController@login');
$router->map('POST', '/login/', 'AuthController@loginPost');
$router->map('POST', '/logout/', 'AuthController@logout');

/**
 * ========== User profile routes ==========
 */
$router->map('GET', '/profile[/]?', 'User\ProfileController@index');
$router->map('GET', '/profile/[i:id]/edit', 'User\ProfileController@edit');
$router->map('POST', '/profile/[i:id]/update', 'User\ProfileController@update');
$router->map('GET', '/profile/[i:id]/edit/password', 'User\ProfileController@editPassword');
$router->map('POST', '/profile/[i:id]/update/password', 'User\ProfileController@updatePassword');
// User Product Routes
$router->map('GET', '/products[/]?', 'ProductController@index');
$router->map('GET', '/products/([0-9]+)[/]?', 'ProductController@show');
/**
 * ========== Admin routes ==========
 */
$router->map('GET', '/admin[/]?', 'Admin\DashboardController@index');
// Admin Product Routes
$router->map('GET', '/admin/products[/]?', 'Admin\ProductController@index');
$router->map('GET', '/admin/products/create[/]?', 'Admin\ProductController@create');
$router->map('POST', '/admin/products/store[/]?', 'Admin\ProductController@store');
$router->map('GET', '/admin/products/[i:id]/edit/', 'Admin\ProductController@edit');
$router->map('POST', '/admin/products/[i:id]/update/', 'Admin\ProductController@update');
$router->map('POST', '/admin/products/[i:id]/delete/', 'Admin\ProductController@delete');
$router->map('GET', '/admin/products/low-stock[/]?', 'Admin\ProductController@lowStock');
$router->map('GET', '/admin/products/out-of-stock[/]?', 'Admin\ProductController@outOfStock');
$router->map('GET', '/admin/products/composition/manage/[i:id]', 'Admin\ProductController@manageComposition');
$router->map('POST', '/admin/products/composition/update/[i:id]', 'Admin\ProductController@updateComposition');


# categories
$router->map('GET', '/admin/categories[/]?', 'Admin\CategoryController@index');
$router->map('GET', '/admin/categories/create[/]?', 'Admin\CategoryController@create');
$router->map('POST', '/admin/categories/store/', 'Admin\CategoryController@store');
$router->map('GET', '/admin/categories/[i:id]/edit/', 'Admin\CategoryController@edit');
$router->map('POST', '/admin/categories/[i:id]/update/', 'Admin\CategoryController@update');
$router->map('POST', '/admin/categories/[i:id]/delete/', 'Admin\CategoryController@delete');

# gifts
$router->map('GET', '/admin/gifts[/]?', 'Admin\GiftController@index');
$router->map('GET', '/admin/gifts/create[/]?', 'Admin\GiftController@create');
$router->map('POST', '/admin/gifts/store', 'Admin\GiftController@store');
$router->map('GET', '/admin/gifts/[i:id]/edit/', 'Admin\GiftController@edit');
$router->map('POST', '/admin/gifts/[i:id]/update/', 'Admin\GiftController@update');
$router->map('POST', '/admin/gifts/[i:id]/delete/', 'Admin\GiftController@delete');
/**
 * ========== Forgot Password routes ==========
 */
$router->map('GET','/forgot-password', 'PasswordResetController@showForgotForm');
$router->map('POST','/forgot-password', 'PasswordResetController@sendResetLink');
$router->map('GET','/reset-password[/]?', 'PasswordResetController@showResetForm');
$router->map('POST','/reset-password', 'PasswordResetController@resetPassword');

# categories routes
$router->map('GET', '/categories/[i:id][/]?', 'CategoryController@show');


# products routes
$router->map('GET', '/products[/]?', 'ProductController@index');

$router->map('GET', '/products/[i:id][/]?', 'ProductController@show');

$router->map('GET', '/gifts[/]?', 'GiftController@index');
$router->map('GET', '/gifts/[i:id][/]?', 'GiftController@show');
$router->map('GET', '/gifts/category/[*:categoryName]', 'GiftController@category');
$router->map('GET', '/categories/[*:slug][/]?', 'CategoryController@showByCategorySlug');

#users routes
$router->map('GET', '/admin/users', 'Admin\UserController@index');
$router->map('GET', '/admin/users/[i:id]/edit', 'Admin\UserController@edit');
$router->map('POST', '/admin/users/[i:id]/update', 'Admin\UserController@update');
$router->map('POST', '/admin/users/[i:id]/delete', 'Admin\UserController@delete');

<<<<<<< HEAD
# Wishlist routes
$router->map('GET', '/profile/wishlist', 'WishlistController@index', 'wishlist.index');
$router->map('POST', '/wishlist/toggle', 'WishlistController@toggle', 'wishlist.toggle');
=======
$router->map('POST', '/review/submit', 'ReviewController@submitReview');
$router->map('GET', '/product/[i:id]', 'ReviewController@show');





>>>>>>> 5b5013822443b5ad2c4f6bca98c3646c1d919816

