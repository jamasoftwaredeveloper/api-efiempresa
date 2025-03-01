<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    /**
     * Crear un carrito para un usuario.
     *
     * @param int $userId
     * @return \App\Models\Cart
     */
    public function createCart($userId);

    /**
     * Obtener el carrito de un usuario con sus productos.
     *
     * @param int $userId
     * @return \App\Models\Cart|null
     */
    public function getCartByUser($userId);

    /**
     * Agregar un producto al carrito.
     *
     * @param int $userId
     * @param int $cartId
     * @param int $productId
     * @param int $quantity
     * @return \App\Models\Cart
     */
    public function addProductToCart($userId, $cartId, $productId, $quantity);

    /**
     * Eliminar un producto del carrito.
     *
     * @param int $userId
     * @param int $cartItemId
     * @return \App\Models\Cart
     */
    public function removeProductFromCart($userId, $cartItemId);

    /**
     * Calcular los impuestos de un carrito.
     *
     * @param int $cartId
     * @return float
     */
    public function calculateTaxes($cartId);

    /**
     * Crear un carrito si no existe para el usuario.
     *
     * @param int $userId
     * @return \App\Models\Cart
     */
    public function createCartIfNotExists($userId);

    /**
     * Crear un carrito si no existe para el usuario.
     *
     * @param int $userId
     * @return boolean
     */
    public function clearCart($userId);
}
