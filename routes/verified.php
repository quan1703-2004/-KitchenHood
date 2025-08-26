<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified']);


