<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllWithFilters($filters)
    {
        $query = Product::query();


        if (isset($filters['search'])) {
            $query->where('name', 'LIKE', "%{$filters['search']}%");
        }
        Log::info($filters['price_min']);
        if (isset($filters['price_min']) && $filters['price_min'] > 0) {
            Log::info("entro");
            $query->where('price', '>=', $filters['price_min']);
        }
        if (isset($filters['price_max']) && $filters['price_max'] > 0) {
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
