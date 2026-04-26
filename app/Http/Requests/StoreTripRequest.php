<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
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
        return [
            'vehicle_id'         => 'required|integer',
            'user_id'            => 'required|integer',
            'route_id'           => 'required|integer',
            'km_departure'       => 'required|numeric|min:0',
            'departure_datetime' => 'required|date',
            'observations'       => 'string'
        ];
    }
}
