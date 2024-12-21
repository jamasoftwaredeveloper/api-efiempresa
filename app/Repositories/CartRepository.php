<?php

// app/Repositories/CartRepository.php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;


class CartRepository implements CartRepositoryInterface
{
    public function createCart($userId)
    {
        return Cart::create(['user_id' => $userId]);
    }

    public function getCartByUser($userId)
    {
        return Cart::with('cartItems.product')->where('user_id', $userId)->first();
    }

    public function addProductToCart($userId, $cartId, $productId, $quantity)
    {
        // Verifica si el producto ya está en el carrito
        $cartItem = CartItem::where('cart_id', $cartId)->where('product_id', $productId)->first();

        if ($cartItem) {
            // Si ya existe, solo actualiza la cantidad
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Si no existe, agrega un nuevo producto al carrito
            CartItem::create([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        // Devuelve el carrito actualizado
        return $this->getCartByUser($userId);
    }

    public function removeProductFromCart($userId, $cartItemId)
    {

        $cart = $this->createCartIfNotExists($userId);
        // Elimina el producto del carrito
        $cartItem = CartItem::where('cart_id',  $cart->id)->where('id', $cartItemId)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        // Devuelve el carrito actualizado
        return $this->getCartByUser($userId);
    }

    public function calculateTaxes($cartId)
    {
        // Lógica de cálculo de impuestos, suponiendo que se usa un 10% de impuestos
        $cart = $this->getCartByUser($cartId);
        $total = $cart->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $taxes = $total * 0.10; // 10% de impuestos

        return $taxes;
    }

    public function createCartIfNotExists($userId)
    {
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            // Si no existe un carrito para el usuario, crea uno
            $cart = Cart::create(['user_id' => $userId]);
        }

        return $cart;
    }
}
