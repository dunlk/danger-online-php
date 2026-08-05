<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreComputerRequest;
use App\Http\Requests\UpdateComputerRequest;
use App\Models\Category;
use App\Models\Computer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $computers = Computer::query()
            ->with('category')
            ->when(
                request('search'),
                fn($query, $search) => $query->where(
                    'name',
                    'ilike',
                    "%{$search}%"
                )
            )
            ->when(
                request('status'),
                fn($query, $status) => $query->where('status', $status)
            )
            ->when(
                request('category_id'),
                fn($query, $categoryId) => $query->where(
                    'category_id',
                    $categoryId
                )
            )
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view(
            'admin.computers.index',
            compact('computers', 'categories')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view('admin.computers.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComputerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('computers', 'public');
        }

        Computer::create($data);

        return redirect()
            ->route('admin.computers.index')
            ->with('succes', 'Computadora creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Computer $computer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Computer $computer)
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view(
            'admin.computers.edit',
            compact('computer', 'categories')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComputerRequest $request, Computer $computer)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($computer->image) {
                Storage::disk('public')->delete($computer->image);
            }

            $data['image'] = $request
                ->file('image')
                ->store('computers', 'public');
        }

        $computer->update($data);

        return redirect()
            ->route('admin.computers.index')
            ->with('succes', 'Computadora actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Computer $computer)
    {
        $computer->delete();

        return redirect()
            ->route('admin.computers.index')
            ->with('succes', 'Computadora eliminada correctamente.');
    }
}
