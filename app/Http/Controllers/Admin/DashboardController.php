<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Computer;
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

        return view('admin.dashboard', compact('stats', 'latestComputers', 'categories'));
    }
}
