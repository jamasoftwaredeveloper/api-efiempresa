<?php

// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Services\CartService;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    /**
     * @OA\Get(
     *     path="/cart",
     *     summary="Obtener el carrito del usuario",
     *     description="Devuelve el carrito del usuario, crea uno si no existe",
     *     tags={"Cart"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Carrito obtenido correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID del carrito"),
     *             @OA\Property(property="user_id", type="integer", description="ID del usuario"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación del carrito"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Fecha de última actualización"),
     *             @OA\Property(
     *                 property="cart_items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="ID del artículo del carrito"),
     *                     @OA\Property(property="cart_id", type="integer", description="ID del carrito asociado"),
     *                     @OA\Property(property="product_id", type="integer", description="ID del producto"),
     *                     @OA\Property(property="quantity", type="integer", description="Cantidad de producto en el carrito"),
     *                     @OA\Property(
     *                         property="product",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", description="ID del producto"),
     *                         @OA\Property(property="name", type="string", description="Nombre del producto"),
     *                         @OA\Property(property="active", type="integer", description="Estado de activación del producto"),
     *                         @OA\Property(property="price", type="string", description="Precio del producto"),
     *                         @OA\Property(property="stock", type="integer", description="Cantidad disponible en inventario"),
     *                         @OA\Property(property="ean", type="string", description="Código EAN del producto")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="No se encuentra el carrito")
     * )
     */
    public function show(Request $request)
    {
        try {
            $cart = $this->cartService->createCartIfNotExists($request->user()->id);

            // Obtener el carrito del usuario
            $cart = $this->cartService->getCartByUser($request->user()->id);
            return response()->json($cart);
        } catch (Exception $e) {
            // Captura la excepción y devuelve una respuesta de error
            return response()->json([
                'error' => 'Error al obtener el carrito',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/cart/add",
     *     summary="Agregar producto al carrito",
     *     description="Agrega un producto al carrito del usuario",
     *     tags={"Cart"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"product_id", "quantity"},
     *             @OA\Property(property="product_id", type="integer", description="ID del producto"),
     *             @OA\Property(property="quantity", type="integer", description="Cantidad del producto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Se ha guardo correctamente el carrito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="ID del carrito"),
     *             @OA\Property(property="user_id", type="integer", description="ID del usuario"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Fecha de creación del carrito"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Fecha de última actualización"),
     *             @OA\Property(
     *                 property="cart_items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", description="ID del artículo del carrito"),
     *                     @OA\Property(property="cart_id", type="integer", description="ID del carrito asociado"),
     *                     @OA\Property(property="product_id", type="integer", description="ID del producto"),
     *                     @OA\Property(property="quantity", type="integer", description="Cantidad de producto en el carrito"),
     *                     @OA\Property(
     *                         property="product",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", description="ID del producto"),
     *                         @OA\Property(property="name", type="string", description="Nombre del producto"),
     *                         @OA\Property(property="active", type="integer", description="Estado de activación del producto"),
     *                         @OA\Property(property="price", type="string", description="Precio del producto"),
     *                         @OA\Property(property="stock", type="integer", description="Cantidad disponible en inventario"),
     *                         @OA\Property(property="ean", type="string", description="Código EAN del producto")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=400, description="Error al agregar producto")
     * )
     */
    public function addToCart(CartRequest $request)
    {
        // Crear el carrito si no existe
        try {
            $cart = $this->cartService->addProductToCart($request->user()->id, $request['product_id'], $request['quantity']);

            return response()->json($cart);
        } catch (Exception $e) {
            // Captura la excepción y devuelve una respuesta de error
            return response()->json([
                'error' => 'Error al agregar el producto al carrito',
                'message' => $e->getMessage()
            ], 400);
        }
    }
    /**
     * @OA\Delete(
     *     path="/cart/remove/{itemId}",
     *     summary="Eliminar producto del carrito",
     *     description="Elimina un producto del carrito del usuario",
     *     tags={"Cart"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="itemId",
     *         in="path",
     *         required=true,
     *         description="ID del artículo a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto eliminado correctamente",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function removeFromCart(Request $request, $itemId)
    {
        try {
            $cart = $this->cartService->removeProductFromCart($request->user()->id, $itemId);
            return response()->json($cart);
        } catch (Exception $e) {
            // Captura la excepción y devuelve una respuesta de error
            return response()->json([
                'error' => 'Error al eliminar el producto del carrito',
                'message' => $e->getMessage()
            ], 404);
        }
    }
    /**
     * @OA\Get(
     *     path="/cart/taxes",
     *     summary="Calcular impuestos del carrito",
     *     description="Calcula los impuestos basados en los productos del carrito",
     *     tags={"Cart"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Impuestos calculados correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="taxes", type="number", format="float", description="El valor de los impuestos calculados")
     *         )
     *     )
     * )
     */
    public function calculateTaxes(Request $request)
    {
        try {
            $taxes = $this->cartService->calculateTaxes($request->user()->id);
            return response()->json(['taxes' => $taxes]);
        } catch (Exception $e) {
            // Captura la excepción y devuelve una respuesta de error
            return response()->json([
                'error' => 'Error al calcular los impuestos',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
