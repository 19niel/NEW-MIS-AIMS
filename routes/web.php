<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    // User Management
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
    
    Route::get('assets/{asset}/history', [AssetController::class, 'history']);
    Route::resource('assets', AssetController::class)->except(['create', 'show', 'edit']);
});

require __DIR__.'/auth.php';
