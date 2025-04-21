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
/**
 * ========== Admin routes ==========
 */
$router->map('GET', '/admin[/]?', 'Admin\DashboardController@index');

/**
 * ========== Forgot Password routes ==========
 */
$router->map('GET','/forgot-password', 'PasswordResetController@showForgotForm');
$router->map('POST','/forgot-password', 'PasswordResetController@sendResetLink');
$router->map('GET','/reset-password[/]?', 'PasswordResetController@showResetForm');
$router->map('POST','/reset-password', 'PasswordResetController@resetPassword');
