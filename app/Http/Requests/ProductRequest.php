<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [];

        // Si el request es una actualización (y no una creación)
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = 'string|max:255';
            $rules['price'] = 'numeric|min:0';
            $rules['active'] = 'boolean';
            $rules['stock'] = 'integer|min:0';
            $rules['ean'] = 'string|size:13';

            // Añadimos la regla de excepción para el EAN
            $rules['ean'] = 'string|size:13|unique:products,ean,' . $this->route('product'); // Excluir el EAN del producto actual si es actualización
        } else {
            $rules['name'] = 'required|string|max:255';
            $rules['price'] = 'required|numeric|min:0';
            $rules['active'] = 'required|boolean';
            $rules['stock'] = 'required|integer|min:0';
            $rules['ean'] = 'required|string|size:13';
            // Si es creación, se aplica la validación sin excepción
            $rules['ean'] = 'required|string|size:13|unique:products,ean';
        }

        return $rules;
    }
}
