<?php

use Illuminate\Support\Facades\Route;

// Mtu akifungua root URL, anatua kwenye fomu ya Login ya Admin
Route::get('/', function () {
    return redirect('/admin/login');
});

// Hii ndiyo inayosuluhisha kabisa error ya "Route [login] not defined" wakati wa redirect au logout
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');