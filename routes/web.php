<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ComputerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth', 'admin'])
//     ->prefix('admin')
//     ->group(function () {
//         Route::get('/dashboard', function () {
//             return "Panel de administración";
//         })->name('admin.dashboard');
//     });

Route::middleware(['auth', 'admin'])

    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('categories', CategoryController::class)
            ->except('show');

        Route::resource('computers', ComputerController::class)
            ->except('show');

        Route::patch(
            'reservations/{reservation}/approve',
            [ReservationController::class, 'approve']
        )->name('reservations.approve');

        Route::patch(
            'reservations/{reservation}/reject',
            [ReservationController::class, 'reject']
        )->name('reservations.reject');

        Route::patch(
            'reservations/{reservation}/cancel',
            [ReservationController::class, 'cancel']
        )->name('reservations.cancel');

        Route::patch(
            'reservations/{reservation}/complete',
            [ReservationController::class, 'complete']
        )->name('reservations.complete');

        Route::resource('reservations', ReservationController::class)
            ->only(['index', 'create', 'store', 'destroy']);
    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__ . '/auth.php';
