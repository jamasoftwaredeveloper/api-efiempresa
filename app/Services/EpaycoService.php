<?php

namespace App\Services;

use App\Repositories\Interfaces\EpaycoRepositoryInterface;
use Exception;
use Epayco\Epayco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EpaycoService
{
    protected $epayco;
    protected $epaycoRepository;

    public function __construct(EpaycoRepositoryInterface $epaycoRepository)
    {
        $this->epaycoRepository = $epaycoRepository;
    }

    /**
     * Inicia la transacción con los datos recibidos.
     *
     * @param Request $request
     * @param string $tokenId
     * @param string $customerId
     * @throws Exception
     */
    public function startTransaction(Request $request, $tokenId, $customerId)
    {
        try {
            return $this->epaycoRepository->startTransaction($request, $tokenId, $customerId);
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
     * @param Request $request
     */
    public function generarToken(Request $request)
    {
        return $this->epaycoRepository->generarToken($request);
    }


    /**
     * Generar el toke ePayco.
     *
     * @param Request $request
     * @param string $tokenId
     */
    public function generarClient(Request $request, $tokenId)
    {
        return $this->epaycoRepository->generarClient($request, $tokenId);
    }
}
