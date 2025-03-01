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

        $token = $this->epaycoService->generarToken($request);

        $client = $this->epaycoService->generarClient($request, $token->id);

        $respuesta = $this->epaycoService->startTransaction($request, $token->id, $client->data->customerId);
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
