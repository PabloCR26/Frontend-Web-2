<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:150',
            'start_point' => 'required|string|max:200',
            'end_point'   => 'required|string|max:200',
            'description' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'El nombre de la ruta es obligatorio.',
            'name.max'             => 'El nombre no puede exceder los 150 caracteres.',
            'start_point.required' => 'El punto de inicio es obligatorio.',
            'end_point.required'   => 'El punto de destino es obligatorio.',
            'description.required' => 'Debes proporcionar una descripción para la ruta.',
        ];
    }
}
