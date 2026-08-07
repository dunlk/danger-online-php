<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Computer;
use Illuminate\View\View;

class ComputerCatalogController extends Controller
{
    public function index(): View
    {
        $computers = Computer::query()
            ->with('category')
            ->whereNotIn('status', ['disabled'])
            ->when(
                request('search'),
                fn($query, $search) => $query->where(
                    'name',
                    'ilike',
                    "%{$search}%"
                )
            )
            ->when(
                request('category_id'),
                fn($query, $categoryId) => $query->where(
                    'category_id',
                    $categoryId
                )
            )
            ->when(
                request('status'),
                fn($query, $status) => $query->where('status', $status)
            )
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view(
            'computers.index',
            compact('computers', 'categories')
        );
    }

    public function show(Computer $computer): View
    {
        $computer->load('category');

        return view('computers.show', compact('computer'));
    }
}
