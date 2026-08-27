<?php

use Illuminate\Support\Facades\Route;

// Mtu akifungua http://127.0.0.1:8000/ anaenda moja kwa moja kwenye Login Form ya /admin
Route::get('/', function () {
    return redirect('/admin');
});