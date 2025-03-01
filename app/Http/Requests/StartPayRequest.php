<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartPayRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Campos obligatorios
            'doc_type'=> 'required|string',
            'doc_number'=> 'required|string',
            'name'=>'required|string',
            'last_name'=> 'required|string',
            'email'=> 'required|string',
            'city'=> 'required|string',
            'address'=>'required|string',
            'phone'=> 'required|string',
            'cell_phone'=> 'required|string',
            'account'=>'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'token_card.required'  => 'El token de la tarjeta es obligatorio.',
            'customer_id.required' => 'El ID del cliente es obligatorio.',
            'doc_number.required'  => 'El número de documento es obligatorio.',
            'name.required'        => 'El nombre es obligatorio.',
            'last_name.required'   => 'El apellido es obligatorio.',
            'email.required'       => 'El correo electrónico es obligatorio.',
            'ip.required'          => 'La IP es obligatoria.',
            'description.required' => 'La descripción es obligatoria.',
            'invoice.required'     => 'El número de factura es obligatorio.',
            'currency.required'    => 'La moneda es obligatoria.',
            'amount.required'      => 'El monto es obligatorio.',
        ];
    }
}
