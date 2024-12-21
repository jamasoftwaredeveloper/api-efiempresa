<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;


class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
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
