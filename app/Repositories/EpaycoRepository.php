<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\EpaycoRepositoryInterface;
use Epayco\Epayco;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EpaycoRepository implements EpaycoRepositoryInterface
{

    protected $epayco;
    public function __construct()
    {
        // Inicializa el SDK utilizando las configuraciones centralizadas
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
     * @param Request $request
     * @param string $tokenId
     * @param string $customerId
     * @throws Exception
     */
    public function startTransaction(Request $request, $tokenId, $customerId)
    {
        try {

            $data = [
                'token_card'  => $tokenId,
                'customer_id' => $customerId,
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
                'doc_type' => $request->doc_type
                // Otros parámetros según la documentación
            ];
            // Aquí puedes ajustar la estructura de $data según la documentación de ePayco
            $response = $this->epayco->charge->create($data);
            return $response;
        } catch (Exception $e) {
            Log::error('Error al iniciar transacción en ePayco: ' . $e->getMessage());
            throw $e;
        }
    }
    /**
     * Generar el toke ePayco.
     *
     * @param Request $request
     */
    public function generarToken(Request $request)
    {
        $data = array(
            "card[number]" => $request->number,
            "card[exp_year]" => $request->exp_year,
            "card[exp_month]" => $request->exp_month,
            "card[cvc]" =>  $request->cvc,
            "hasCvv" => true
        );
        $token =  $this->epayco->token->create($data);

        return $token; // Retorna true si la validación es exitosa.
    }


    /**
     * Generar el toke ePayco.
     *
     * @param Request $request
     * @param string $tokenId
     */
    public function generarClient(Request $request, $tokenId)
    {
        $clientData = array(
            "token_card" => $tokenId,
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
        $customer = $this->epayco->customer->create($clientData);

        return $customer; // Retorna true si la validación es exitosa.
    }
}
