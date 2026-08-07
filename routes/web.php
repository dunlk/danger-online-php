<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ComputerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\ComputerCatalogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController as UserReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
    ], 200);
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
            'reservations/{reservation}/start',
            [AdminReservationController::class, 'start']
        )->name('reservations.start');

        Route::patch(
            'reservations/{reservation}/approve',
            [AdminReservationController::class, 'approve']
        )->name('reservations.approve');

        Route::patch(
            'reservations/{reservation}/reject',
            [AdminReservationController::class, 'reject']
        )->name('reservations.reject');

        Route::patch(
            'reservations/{reservation}/cancel',
            [AdminReservationController::class, 'cancel']
        )->name('reservations.cancel');

        Route::patch(
            'reservations/{reservation}/complete',
            [AdminReservationController::class, 'complete']
        )->name('reservations.complete');

        Route::resource('reservations', AdminReservationController::class)
            ->only(['index', 'create', 'store', 'destroy']);
    });

Route::middleware('auth')->group(function () {
    Route::get(
        '/reservations',
        [UserReservationController::class, 'index']
    )->name('reservations.index');

    Route::get(
        '/computers/{computer}/reserve',
        [UserReservationController::class, 'create']
    )->name('reservations.create');

    Route::post(
        '/computers/{computer}/reserve',
        [UserReservationController::class, 'store']
    )->name('reservations.store');

    Route::patch(
        '/reservations/{reservation}/cancel',
        [UserReservationController::class, 'cancel']
    )->name('reservations.cancel');
});

Route::get('/computers', [ComputerCatalogController::class, 'index'])
    ->name('computers.index');

Route::get('/computers/{computer}', [ComputerCatalogController::class, 'show'])
    ->name('computers.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__ . '/auth.php';
