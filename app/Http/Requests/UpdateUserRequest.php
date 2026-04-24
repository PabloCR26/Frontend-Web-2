<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email', 
            'telephone' => 'required|string|max:30',
            'role_id'   => 'required|integer',
            'password'  => 'nullable|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'Debes ingresar un correo válido.',
            'telephone.required' => 'El teléfono es obligatorio.',
            'role_id.required'   => 'Debes seleccionar un rol.',
            'password.min'       => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }
}
