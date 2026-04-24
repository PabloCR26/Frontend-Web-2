<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'plate'     => 'required|string|max:20',
            'brand'     => 'required|string|max:50',
            'model'     => 'required|string|max:50',
            'year'      => 'required|numeric|min:1900|max:' . (date('Y') + 1),
            'type'      => 'required|in:sedan,pickup,suv,moto,van',
            'capacity'  => 'required|numeric|min:1',
            'fuel_type' => 'required|in:gasolina,diesel,hibrido,electrico',
            'status'    => 'required|in:available,assigned,maintenance',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'plate.required'     => 'La placa es un campo obligatorio.',
            'plate.max'          => 'La placa no puede tener más de 20 caracteres.',
            'brand.required'     => 'Debes indicar la marca del vehículo.',
            'model.required'     => 'El modelo es obligatorio.',
            'year.required'      => 'El año es obligatorio.',
            'year.numeric'       => 'El año debe ser un valor numérico.',
            'year.min'           => 'El año no es válido.',
            'year.max'           => 'El año no puede ser superior al próximo año.',
            'type.required'      => 'Selecciona un tipo de vehículo.',
            'type.in'            => 'El tipo seleccionado no es válido.',
            'capacity.required'  => 'La capacidad de personas es obligatoria.',
            'capacity.numeric'   => 'La capacidad debe ser un número.',
            'fuel_type.required' => 'El tipo de combustible es obligatorio.',
            'image.image'        => 'El archivo debe ser una imagen real.',
            'image.mimes'        => 'La imagen debe ser formato: jpg, jpeg o png.',
            'image.max'          => 'La imagen es muy pesada (máximo 2MB).',
            'status.required'    => 'El estado del vehículo es obligatorio.',
        ];
    }
}
