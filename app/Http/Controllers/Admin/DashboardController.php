<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Computer;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'computers' => Computer::count(),
            'available' => Computer::where('status', 'available')->count(),
            'occupied' => Computer::where('status', 'occupied')->count(),
            'maintenance' => Computer::where('status', 'maintenance')->count(),
            'disabled' => Computer::where('status', 'disabled')->count(),
            'categories' => Category::count(),

            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'approved_reservations' => Reservation::where('status', 'approved')->count(),
            'completed_reservations' => Reservation::where('status', 'completed')->count(),
            'completed_income' => Reservation::where('status', 'completed')
                ->sum('total_price'),
        ];

        $latestComputers = Computer::query()
            ->with('category')
            ->latest()
            ->limit(5)
            ->get();

        $categories = Category::query()
            ->withCount('computers')
            ->orderByDesc('computers_count')
            ->get();

        $latestReservations = Reservation::query()
            ->with(['user', 'computer'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'latestComputers',
            'categories',
            'latestReservations',
        ));
    }
}
