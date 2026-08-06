<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'computer_id' => [
                'required',
                'integer',
                'exists:computers,id',
            ],
            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'duration_hours' => [
                'required',
                'integer',
                'min:1',
                'max:12',
            ],
            'status' => [
                'sometimes',
                Rule::in([
                    'pending',
                    'approved',
                    'rejected',
                    'cancelled',
                    'completed',
                ]),
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'resertation_date.after_or_equal' => 'La fecha de reserva no puede ser anterior a la de hoy.',
            'start_time.date_format' => 'La hora debe tener un formato válido.',
            'duratoin_our_max' => 'Una reserva no puede superar las 12 horas.',
        ];
    }
}
