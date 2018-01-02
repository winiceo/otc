<?php



Route::get('/', 'HomeController@welcome');
Route::get('/auth/login', 'Auth\\LoginController@showLoginForm')->name('login');
Route::post('/auth/login', 'Auth\\LoginController@login');
Route::any('auth/logout', 'Auth\\LoginController@logout')->name('logout');

Route::prefix('admin')
    ->namespace('Admin')
    ->group(base_path('routes/admin.php'));
