<?php

namespace App\Services;

use App\Models\Computer;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class ReservationService
{
    public function create(array $data, int $userId): Reservation
    {
        $computer = Computer::findOrFail($data['computer_id']);

        if ($computer->hourly_price === null) {
            throw ValidationException::withMessages([
                'computer_id' => 'La computadora seleccionada no tiene precio por hora configurado.',
            ]);
        }

        $hourlyPrice = (float) $computer->hourly_price;
        $durationHours = (int) $data['duration_hours'];

        $totalPrice = $hourlyPrice * $durationHours;

        $this->ensureComputerIsAvailable(
            $computer,
            $data['reservation_date'],
            $data['start_time'],
            $durationHours
        );

        return Reservation::create([
            'user_id' => $userId,
            'computer_id' => $computer->id,
            'reservation_date' => $data['reservation_date'],
            'start_time' => $data['start_time'],
            'duration_hours' => $durationHours,

            'hourly_price' => $hourlyPrice,
            'total_price' => $totalPrice,

            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);
    }

    public function ensureComputerIsAvailable(
        Computer $computer,
        string $date,
        string $startTime,
        int $duration
    ): void {
        $newStart = Carbon::parse(
            "{$date} {$startTime}"
        );

        $newEnd = $newStart
            ->copy()
            ->addHours($duration);

        $reservations = Reservation::query()
            ->where('computer_id', $computer->id)
            ->where('reservation_date', $date)
            ->whereIn('status', [
                'pending',
                'approved',
            ])
            ->get();

        foreach ($reservations as $reservation) {
            $existingStart = Carbon::parse(
                $reservation->reservation_date->format('Y-m-d')
                . " {$reservation->start_time}"
            );

            $existingEnd = $existingStart
                ->copy()
                ->addHours($reservation->duration_hours);

            if (
                $newStart < $existingEnd
                && $newEnd > $existingStart
            ) {
                throw ValidationException::withMessages([
                    'start_time' => 'La computadora ya tiene una reserva en ese horario.',
                ]);
            }
        }
    }
}
