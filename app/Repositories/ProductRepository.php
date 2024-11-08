<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAllWithFilters($filters)
    {
        $query = Product::query();

        if (isset($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }
        if (isset($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        // Filtrar por disponibilidad (stock mayor a 0)
        if (isset($filters['available']) && $filters['available'] == 'true') {
            $query->where('stock', '>', 0); // Mostrar solo productos disponibles
        }

        // Filtrar por código EAN
        if (isset($filters['ean'])) {
            $query->where('ean', 'like', '%' . $filters['ean'] . '%');
        }
        return $query;
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }
}
