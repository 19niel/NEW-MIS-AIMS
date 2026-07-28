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
    $activeAssets = \App\Models\Asset::whereIn('condition', ['Available', 'Deployed', 'Active'])->count();
    $totalAssets = \App\Models\Asset::count();
    $inactiveAssets = $totalAssets - $activeAssets;

    $activeEmployees = \App\Models\Employee::where('employment_status', 'Active')->count();
    $totalEmployees = \App\Models\Employee::count();
    $inactiveEmployees = $totalEmployees - $activeEmployees;

    $totalUsers = \App\Models\User::count();
    $activeUsers = \App\Models\User::where('status', 'Active')->count();
    $inactiveUsers = $totalUsers - $activeUsers;
    
    $recentAssets = \App\Models\Asset::with('category', 'assignedEmployee')->latest()->take(5)->get();
    
    return view('dashboard', compact(
        'activeAssets', 'totalAssets', 'inactiveAssets',
        'activeEmployees', 'totalEmployees', 'inactiveEmployees',
        'totalUsers', 'activeUsers', 'inactiveUsers',
        'recentAssets'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Employee Management
    Route::post('employees/import', [EmployeeController::class, 'import'])->name('employees.import');
    Route::get('employees/import-template', [EmployeeController::class, 'downloadTemplate'])->name('employees.import-template');
    Route::get('employees/{employee}/print-accountability', [EmployeeController::class, 'printAccountability'])->name('employees.print-accountability');
    Route::get('employees/{employee}/history', [EmployeeController::class, 'history'])->name('employees.history');
    Route::resource('employees', EmployeeController::class);
    // User Management
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
    
    // Reports
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    
    // Audit Logs
    Route::get('audit-logs', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit-logs.index');
    
    // Settings (Asset Categories)
    Route::get('settings', [\App\Http\Controllers\AssetCategoryController::class, 'index'])->name('settings.index');
    Route::post('settings/categories', [\App\Http\Controllers\AssetCategoryController::class, 'store'])->name('settings.categories.store');
    Route::put('settings/categories/{id}', [\App\Http\Controllers\AssetCategoryController::class, 'update'])->name('settings.categories.update');
    Route::delete('settings/categories/{id}', [\App\Http\Controllers\AssetCategoryController::class, 'destroy'])->name('settings.categories.destroy');
    
    Route::get('assets/{asset}/history', [AssetController::class, 'history']);
    Route::resource('assets', AssetController::class)->except(['create', 'show', 'edit']);
});

require __DIR__.'/auth.php';
