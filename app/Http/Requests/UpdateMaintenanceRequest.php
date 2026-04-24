<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'        => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'cost'        => 'nullable|numeric|min:0',
            'status'      => 'required|in:open,closed',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'          => 'El tipo de mantenimiento es obligatorio.',
            'description.required'   => 'Debes agregar una descripción.',
            'status.required'        => 'El estado es obligatorio.',
            'status.in'              => 'El estado seleccionado no es válido.',
            'end_date.date'          => 'La fecha de fin no es válida.',
            'end_date.after_or_equal'=> 'La fecha de fin no puede ser anterior a la fecha de inicio.',
        ];
    }
}
