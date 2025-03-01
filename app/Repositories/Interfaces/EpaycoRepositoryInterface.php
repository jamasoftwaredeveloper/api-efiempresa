<?php
namespace App\Repositories\Interfaces;
use App\Models\Product;
use Illuminate\Http\Request;

interface EpaycoRepositoryInterface
{
    public function startTransaction(Request $request, $tokenId, $customerId);
    public function generarToken(Request $request);
    public function generarClient(Request $request, $tokenId);
}
