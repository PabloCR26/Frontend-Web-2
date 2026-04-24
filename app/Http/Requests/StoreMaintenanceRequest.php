<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id'  => 'required|integer',
            'type'        => 'required|string|max:100',
            'start_date'  => 'required|date',
            'description' => 'required|string|max:500',
            'cost'        => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_id.required'  => 'Debes seleccionar un vehículo.',
            'type.required'        => 'El tipo de mantenimiento es obligatorio.',
            'start_date.required'  => 'La fecha de inicio es obligatoria.',
            'start_date.date'      => 'La fecha de inicio no es válida.',
            'description.required' => 'Debes agregar una descripción del problema o trabajo.',
            'cost.numeric'         => 'El costo debe ser un valor numérico.',
            'cost.min'             => 'El costo no puede ser negativo.',
        ];
    }
}
