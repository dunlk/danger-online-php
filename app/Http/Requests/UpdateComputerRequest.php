<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateComputerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $computer = $this->route('computer');

        return [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:20',
                'regex:/^PC-\d{2,3}$/',
                Rule::unique('computers', 'name')->ignore($computer),
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'processor' => [
                'required',
                'string',
                'max:100',
            ],
            'ram' => [
                'required',
                'integer',
                'min:1',
                'max:1024',
            ],
            'graphics' => [
                'nullable',
                'string',
                'max:100',
            ],
            'storage' => [
                'required',
                'string',
                'max:100',
            ],
            'hourly_price' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],
            'status' => [
                'required',
                Rule::in([
                    'available',
                    'occupied',
                    'maintenance',
                    'disabled',
                ]),
            ],
            'image' => [
                'nullable',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }

    public function messages(): array
    {
        return[
            'name.regex' => 'El nombre debe tener un formato como PC-01 o PC-100.',
            'category_id.exists' => 'La categoria seleccionada no existe.',
            'image.max' => 'La imagen no puede superar los 2 MB.',
        ];
    }
}
