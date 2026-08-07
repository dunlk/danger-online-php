<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Computer;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $reservations = Reservation::query()
            ->with(['user', 'computer.category'])
            ->when(
                request('search'),
                function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query
                            ->whereHas(
                                'user',
                                fn($userQuery) => $userQuery
                                    ->where('name', 'ilike', "%{$search}%")
                                    ->orWhere('email', 'ilike', "%{$search}%")
                            )
                            ->orWhereHas(
                                'computer',
                                fn($computerQuery) => $computerQuery
                                    ->where('name', 'ilike', "%{$search}%")
                            );
                    });
                }
            )
            ->when(
                request('status'),
                fn($query, $status) => $query->where('status', $status)
            )
            ->when(
                request('date'),
                fn($query, $date) => $query->whereDate('reservation_date', $date)
            )
            ->orderByDesc('reservation_date')
            ->orderByDesc('start_time')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.reservations.index',
            compact('reservations')
        );
    }

    public function start(Reservation $reservation): RedirectResponse
    {
        if ($reservation->status !== 'approved') {
            return back()->with(
                'error',
                'Solo se pueden iniciar reservas aprobadas.'
            );
        }

        if ($reservation->computer->status !== 'available') {
            return back()->with(
                'error',
                'La computadora no está disponible en este momento.'
            );
        }

        $reservation->update([
            'status' => 'active',
        ]);

        $reservation->computer->update([
            'status' => 'occupied',
        ]);

        return back()->with(
            'success',
            'La reserva fue iniciada y la computadora ahora está ocupada.'
        );
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $computers = Computer::query()
            ->with('category')
            ->whereNotIn('status', ['maintenance', 'disabled'])
            ->orderBy('name')
            ->get();

        return view('admin.reservations.create', compact('computers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request, ReservationService $reservationService): RedirectResponse
    {
        $reservationService->create(
            $request->validated(),
            $request->user()->id,
        );

        return redirect()
            ->route('admin.reservations.index')
            ->with(
                'succes',
                'Reserva creada correctamente.'
            );
    }

    public function approve(Reservation $reservation): RedirectResponse
    {
        if ($reservation->status !== 'pending') {
            return back()->with(
                'error',
                'Solo se puede aprobar reservas pendientes.'
            );
        }


        $reservation->update([
            'status' => 'approved',
        ]);

        return back()->with(
            'succes',
            'Reserva aprobada correctamente.'
        );
    }

    public function reject(Reservation $reservation): RedirectResponse
    {
        if ($reservation->status !== 'pending') {
            return back()->with(
                'error',
                'Solo se puede rechazar reservas pendientes.'
            );
        }

        $reservation->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'succes',
            'Reserva rechazada correctamente.'
        );
    }

    public function cancel(Reservation $reservation): RedirectResponse
    {
        if (! in_array($reservation->status, ['pending', 'approved'], true)) {
            return back()->with(
                'error',
                'Esta reserva ya no se puede cancelar.'
            );
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return back()->with(
            'succes',
            'Reserva cancelada correctamente.'
        );
    }

    public function complete(Reservation $reservation): RedirectResponse
    {
        if ($reservation->status !== 'active') {
            return back()->with(
                'error',
                'Solo se pueden finalizar reservas activas.'
            );
        }

        $reservation->update([
            'status' => 'completed',
        ]);

        $reservation->computer->update([
            'status' => 'available',
        ]);

        return back()->with(
            'success',
            'Reserva finalizada y computadora liberada correctamente.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        if (in_array($reservation->status, ['approved', 'completed'], true)) {
            return back()->with(
                'error',
                'No se puede eliminar una reserva aprobada o finalizada.'
            );
        }

        $reservation->delete();

        return redirect()
            ->route('admin.reservations.index')
            ->with('succes', 'Reserva eliminada correctamente.');
    }
}
