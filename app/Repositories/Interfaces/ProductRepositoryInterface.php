<?php
namespace App\Repositories\Interfaces;
use App\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * Obtener todos los productos con filtros.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getAllWithFilters(array $filters);

    /**
     * Crear un nuevo producto.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data);

    /**
     * Actualizar un producto existente.
     *
     * @param Product $product
     * @param array $data
     * @return Product
     */
    public function update(Product $product, array $data);
}
