<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getUserCart()->load('items.product');
        $cartItems = $cart->items;
        $total = $cartItems->sum('subtotal');

        return view('dashboard.user.cart', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::with('category')->findOrFail($productId);

        if ($product->stock <= 0) {
            return $this->respondError($request, 'Produk tidak tersedia.');
        }

        $cart = $this->getUserCart();
        $cartItem = $cart->items()->where('product_id', $productId)->first();
        
        // Cari promo aktif untuk produk ini
        $now = now();
        $promo = \App\Models\Promo::where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->where(function($query) use ($product) {
                $query->where('product_id', $product->id)
                      ->orWhere('category_id', $product->category_id);
            })
            ->first();
        
        // Hitung harga dengan promo
        $price = $product->discount_price ?? $product->price;
        if ($promo) {
            if ($promo->discount_type === 'percentage') {
                $discount = ($product->price * $promo->discount_value) / 100;
                if ($promo->max_discount && $discount > $promo->max_discount) {
                    $discount = $promo->max_discount;
                }
                $promoPrice = $product->price - $discount;
                if ($promoPrice < $price) {
                    $price = $promoPrice;
                }
            } else {
                $promoPrice = $product->price - $promo->discount_value;
                if ($promoPrice < $price && $promoPrice >= 0) {
                    $price = $promoPrice;
                }
            }
        }

        if ($cartItem) {
            if ($cartItem->quantity >= $product->stock) {
                return $this->respondError($request, 'Stok tidak mencukupi.');
            }
            $cartItem->quantity += 1;
        } else {
            $cartItem = new CartItem([
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $price,
            ]);
        }

        $cartItem->price = $price;
        $cartItem->subtotal = $cartItem->quantity * $price;
        $cart->items()->save($cartItem);
        $cart->update(['last_activity_at' => now()]);

        return $this->respondSuccess($request, $cart);
    }

    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            return $this->remove($productId);
        }

        if ($quantity > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = $this->getUserCart();
        $cartItem = $cart->items()->where('product_id', $productId)->firstOrFail();

        $price = $product->discount_price ?? $product->price;
        $cartItem->update([
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $quantity * $price,
        ]);
        $cart->update(['last_activity_at' => now()]);

        return back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function remove($productId)
    {
        $cart = $this->getUserCart();
        $cart->items()->where('product_id', $productId)->delete();
        $cart->update(['last_activity_at' => now()]);

        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function clear()
    {
        $cart = $this->getUserCart();
        $cart->items()->delete();
        $cart->update(['last_activity_at' => now()]);

        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }

    public function getCount()
    {
        $cart = $this->getUserCart();
        $count = $cart->items()->sum('quantity');
        return response()->json(['count' => $count]);
    }

    protected function getUserCart(): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['status' => 'active', 'last_activity_at' => now()]
        );
    }

    protected function respondSuccess(Request $request, Cart $cart)
    {
        $count = $cart->items()->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang',
                'cart_count' => $count,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    protected function respondError(Request $request, string $message)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }

        return back()->with('error', $message);
    }
}

