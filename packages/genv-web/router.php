<?php

use Illuminate\Support\Facades\Route;

// Web routes.
Route::group(['middleware' => ['web']], __DIR__.'/routes/web.php');

Route::group(['middleware' => ['web', 'auth', 'admin']], __DIR__.'/routes/admin.php');
