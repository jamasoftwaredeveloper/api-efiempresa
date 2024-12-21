<?php

namespace App\Services;

use App\Repositories\CartRepository;
use App\Repositories\Interfaces\CartRepositoryInterface;

class CartService
{
    protected $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function createCart($userId)
    {
        return $this->cartRepository->createCart($userId);
    }

    public function getCartByUser($userId)
    {
        return $this->cartRepository->getCartByUser($userId);
    }

    public function addProductToCart($userId, $productId, $quantity)
    {
        // Asegurarse de que el carrito exista
        $cart = $this->createCartIfNotExists($userId);

        return $this->cartRepository->addProductToCart($userId, $cart->id , $productId, $quantity);
    }

    public function removeProductFromCart($userId, $cartItemId)
    {
        return $this->cartRepository->removeProductFromCart($userId, $cartItemId);
    }

    public function calculateTaxes($userId)
    {
        return $this->cartRepository->calculateTaxes($userId);
    }
    public function createCartIfNotExists($userId)
    {
        return $this->cartRepository->createCartIfNotExists($userId);
    }
}
