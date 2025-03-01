<?php

// app/Repositories/CartRepository.php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CartRepository implements CartRepositoryInterface
{
    public function createCart($userId)
    {
        return Cart::create(['user_id' => $userId]);
    }

    public function getCartByUser($userId)
    {

        $cartItems = CartItem::with(['product:id,name,image,price'])
            ->whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->select('product_id', 'quantity')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return [
            'total' => $total,
            'items' => $cartItems,
        ];
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
        $cartItem = CartItem::where('cart_id',  $cart->id)->where('product_id', $cartItemId)->first();

        if ($cartItem) {
            // Si la cantidad es mayor a 1, se decrementa; si es 1, se elimina el registro
            if ($cartItem->quantity > 1) {
                $cartItem->quantity = $cartItem->quantity - 1;
                $cartItem->save();
            } else {
                $cartItem->delete();
            }
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
            $cart = $this->createCart($userId);
        }

        return $cart;
    }

    public function clearCart($userId)
    {

        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json(['message' => 'No hay carrito para eliminar'], 404);
        }

        // Eliminar todos los elementos del carrito
        $cart->cartItems()->delete();

        // Eliminar el carrito
        return $cart->delete();
    }
}
