<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
        return [
            'product_id' => 'required|exists:products,id', // El producto debe existir en la base de datos
            'quantity' => 'required|integer|min:1', // La cantidad debe ser al menos 1
        ];
    }
}
