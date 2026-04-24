<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
            'image'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'plate.required'     => 'La placa es obligatoria.',
            'brand.required'     => 'La marca es obligatoria.',
            'year.numeric'       => 'El año debe ser un número válido.',
            'image.required'     => 'Debes subir una imagen del vehículo.',
            'image.image'        => 'El archivo debe ser una imagen (jpg, png, jpeg).',
            'image.max'          => 'La imagen no debe pesar más de 2MB.',
            'type.in'            => 'El tipo de vehículo seleccionado no es válido.',
        ];
    }
}
