<?php

namespace App\Services;

use Exception;
use Epayco\Epayco;
use Illuminate\Support\Facades\Log;

class EpaycoService
{
    protected $epayco;

    public function __construct()
    {
        // Inicializa el SDK utilizando las configuraciones centralizadas
        Log::info( config('services.epayco.private_key'));
        Log::info( config('services.epayco.public_key'));
        Log::info( config('services.epayco.test'));
        $this->epayco = new Epayco([
            'apiKey'     => config('services.epayco.public_key'),
            'privateKey' => config('services.epayco.private_key'),
            'test'       => config('services.epayco.test'),
            'lenguage'   => 'ES'
        ]);
    }

    /**
     * Inicia la transacción con los datos recibidos.
     *
     * @param array $data
     * @throws Exception
     */
    public function startTransaction(array $data)
    {
        try {
            // Aquí puedes ajustar la estructura de $data según la documentación de ePayco
            $response = $this->epayco->charge->create($data);
            return $response;
        } catch (Exception $e) {
            Log::error('Error al iniciar transacción en ePayco: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Valida la respuesta de ePayco.
     *
     * @param array $responseData
     * @return bool
     */
    public function validateResponse(array $responseData): bool
    {
        Log::info('Contenido del array: ' . print_r($responseData, true));
        // Implementa la lógica para validar la firma y estado de la transacción.
        // Esto puede incluir cálculos con HMAC y comparar el resultado con el valor recibido.
        return true; // Retorna true si la validación es exitosa.
    }

    /**
     * Generar el toke ePayco.
     *
     * @param array $data
     */
    public function generarToken(array $data)
    {
        $token =  $this->epayco->token->create($data);

        return $token; // Retorna true si la validación es exitosa.
    }


        /**
     * Generar el toke ePayco.
     *
     * @param array $data
     */
    public function generarClient(array $data)
    {
        $customer = $this->epayco->customer->create($data);

        return $customer; // Retorna true si la validación es exitosa.
    }
}
