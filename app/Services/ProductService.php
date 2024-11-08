<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductsWithFilters($filters)
    {
        return $this->productRepository->getAllWithFilters($filters);
    }

    public function createProduct($data)
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct($product, $data)
    {
        return $this->productRepository->update($product, $data);
    }
}
