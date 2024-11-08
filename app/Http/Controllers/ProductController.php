<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * @OA\Get(
     *     path="/products",
     *     summary="Obtener productos",
     *     description="Devuelve una lista de productos, con la opción de filtrar por precio, disponibilidad o EAN",
     *     tags={"Product"},
     *     @OA\Parameter(
     *         name="price_min",
     *         in="query",
     *         description="Precio mínimo",
     *         required=false,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="price_max",
     *         in="query",
     *         description="Precio máximo",
     *         required=false,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="available",
     *         in="query",
     *         description="Disponibilidad del producto (1 = disponible, 0 = no disponible)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="ean",
     *         in="query",
     *         description="Código EAN del producto",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos obtenida correctamente",
     *         @OA\JsonContent(
     *             required={"name", "price", "stock", "ean"},
     *             @OA\Property(property="name", type="string", description="Nombre del producto"),
     *             @OA\Property(property="price", type="string", description="Precio del producto"),
     *             @OA\Property(property="stock", type="integer", description="Cantidad disponible en stock"),
     *             @OA\Property(property="ean", type="string", description="Código EAN del producto"),
     *             @OA\Property(property="active", type="integer", description="Estado de disponibilidad (1=activo, 0=inactivo)", example=1)
     *         )
     *     ),
     *     @OA\Response(response=400, description="Parámetros de filtro inválidos")
     * )
     */
    public function index(Request $request)
    {
        try {
            $filters = $request->only(['price_min', 'price_max', 'available', 'ean']);
            $query = $this->productService->getProductsWithFilters($filters);
            $products = $query->paginate(15);
            return new ProductCollection($products);
        } catch (Exception $e) {
            // Captura la excepción y devuelve una respuesta de error
            return response()->json([
                'error' => 'Error al listar productos',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/products",
     *     summary="Crear producto",
     *     description="Crea un nuevo producto en el sistema",
     *     tags={"Product"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "stock", "ean"},
     *             @OA\Property(property="name", type="string", description="Nombre del producto"),
     *             @OA\Property(property="price", type="string", description="Precio del producto"),
     *             @OA\Property(property="stock", type="integer", description="Cantidad disponible en stock"),
     *             @OA\Property(property="ean", type="string", description="Código EAN del producto"),
     *             @OA\Property(property="active", type="integer", description="Estado de disponibilidad (1=activo, 0=inactivo)", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producto creado correctamente",
     *         @OA\JsonContent(
     *             required={"name", "price", "stock", "ean"},
     *             @OA\Property(property="name", type="string", description="Nombre del producto"),
     *             @OA\Property(property="price", type="string", description="Precio del producto"),
     *             @OA\Property(property="stock", type="integer", description="Cantidad disponible en stock"),
     *             @OA\Property(property="ean", type="string", description="Código EAN del producto"),
     *             @OA\Property(property="active", type="integer", description="Estado de disponibilidad (1=activo, 0=inactivo)", example=1)
     *         )
     *     ),
     *     @OA\Response(response=400, description="Error al crear el producto")
     * )
     */
    public function store(ProductRequest  $request)
    {
        try {
            $product =  $this->productService->createProduct($request->all());
            return new ProductResource($product);
        } catch (Exception $e) {
            // Captura la excepción y devuelve una respuesta de error
            return response()->json([
                'error' => 'Error al guardar el producto',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     summary="Actualizar producto",
     *     description="Actualiza un producto existente en el sistema",
     *     tags={"Product"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "stock", "ean"},
     *             @OA\Property(property="name", type="string", description="Nombre del producto"),
     *             @OA\Property(property="price", type="string", description="Precio del producto"),
     *             @OA\Property(property="stock", type="integer", description="Cantidad disponible en stock"),
     *             @OA\Property(property="ean", type="string", description="Código EAN del producto"),
     *             @OA\Property(property="active", type="integer", description="Estado de disponibilidad (1=activo, 0=inactivo)", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado correctamente",
     *         @OA\JsonContent(
     *             required={"name", "price", "stock", "ean"},
     *             @OA\Property(property="name", type="string", description="Nombre del producto"),
     *             @OA\Property(property="price", type="string", description="Precio del producto"),
     *             @OA\Property(property="stock", type="integer", description="Cantidad disponible en stock"),
     *             @OA\Property(property="ean", type="string", description="Código EAN del producto"),
     *             @OA\Property(property="active", type="integer", description="Estado de disponibilidad (1=activo, 0=inactivo)", example=1)
     *         )
     *     ),
     *     @OA\Response(response=400, description="Error al actualizar el producto"),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function update(ProductRequest  $request, Product $product)
    {
        try {

            $productUpdated =  $this->productService->updateProduct($product, $request->all());
            return new ProductResource($productUpdated);
        } catch (Exception $e) {
            // Captura la excepción y devuelve una respuesta de error
            return response()->json([
                'error' => 'Error al actualiza el producto',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
