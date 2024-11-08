<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Si no hay lógica de autorización, retorna `true`
    }

    /**
     * Obtén las reglas de validación que se aplican a la solicitud.
     *
     * @return array
     */
    public function rules()
    {

            // Registro de usuario
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|confirmed|min:8', // Confirmación de password
            ];

    }
}
