<?php

namespace App\Http\Controllers;

use App\Services\EpaycoService;
use Illuminate\Http\Request;

class EpaycoController extends Controller
{
    protected $epaycoService;

    public function __construct(EpaycoService $epaycoService)
    {
        $this->epaycoService = $epaycoService;
    }

    /**
     * Inicia la transacción.
     */
    public function startPay(Request $request)
    {

        $data = array(
            "card[number]" => $request->number,
            "card[exp_year]" => $request->exp_year,
            "card[exp_month]" => $request->exp_month,
            "card[cvc]" =>  $request->cvc,
            "hasCvv" => true
        );

        $token = $this->epaycoService->generarToken($data);

        $clientData = array(
            "token_card" => $token->id,
            "name" => $request->name,
            "last_name" =>  $request->last_name, //This parameter is optional
            "email" => $request->email,
            "default" => true,
            //Optional parameters: These parameters are important when validating the credit card transaction
            "city" => $request->city,
            "address" => $request->address,
            "phone" => $request->phone,
            "cell_phone" => $request->cell_phone,
        );

        $client = $this->epaycoService->generarClient($clientData);

        $data = [
            'token_card'  => $token->id,
            'customer_id' => $client->data->customerId,
            'doc_number'  => $request->doc_number,
            'name'        => $request->name,
            'last_name'   => $request->last_name,
            'email'       => $request->email,
            'city'        => $request->city,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'cell_phone'  => $request->cell_phone,
            'ip'          => $request->ip(),
            'description' => 'Compra de producto X',
            'invoice'     => uniqid("fact_"),
            'currency'    => 'COP',
            'value'      => $request->account,
            'tax_base'    => 0,
            'tax'         => 0,
            'test'        => config('services.epayco.test'),
            'doc_type'=>$request->doc_type
            // Otros parámetros según la documentación
        ];

        $respuesta = $this->epaycoService->startTransaction($data);
        return response()->json($respuesta);
    }


    /**
     * Callback para la respuesta de ePayco.
     */
    public function responsePay(Request $request)
    {
        $responseData = $request->all();

        if ($this->epaycoService->validateResponse($responseData)) {
            // Actualiza el estado de la orden en la base de datos
            return view('pago.respuesta', ['status' => $responseData['x_response'] ?? '']);
        } else {
            // Maneja la situación de validación fallida
            return response()->json(['error' => 'Transacción inválida'], 400);
        }
    }
}
