<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Computer;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = Reservation::query()
            ->with('computer.category')
            ->where('user_id', auth()->id())
            ->latest('reservation_date')
            ->latest('start_time')
            ->paginate(11);

        return view(
            'reservations.index',
            compact('reservations')
        );
    }

    public function create(Computer $computer): View
    {
        if (in_array($computer->status, ['maintenance', 'disabled'], true)) {
            abort(404);
        }

        $computer->load('category');

        return view(
            'reservations.create',
            compact('computer')
        );
    }

    public function store(
        StoreReservationRequest $request,
        Computer $computer,
        ReservationService $reservationService
    ): RedirectResponse {
        if ((int) $request->validated('computer_id') !== $computer->id) {
            abort(422);
        }

        $reservationService->create(
            $request->validated(),
            $request->user()->id,
        );

        return redirect()
            ->route('reservations.index')
            ->with(
                'success',
                'Tu reserva fue registrada correctamente y está pendiente de aprobación.'
            );
    }

    public function cancel(Reservation $reservation): RedirectResponse
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->status !== 'pending') {
            return back()->with(
                'error',
                'Solo puedes cancelar reservas pendientes.'
            );
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return back()->with(
            'success',
            'Reserva cancelada correctamente.'
        );
    }
}
