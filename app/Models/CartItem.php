<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    /**
     * Relación con el carrito.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Relación con el producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calcular el total de este item en el carrito.
     */
    public function getTotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }
}
