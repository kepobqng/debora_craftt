<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua user dengan cart yang memiliki items (ini adalah "pesanan" dari user yang membeli produk)
        $carts = Cart::with(['user', 'items.product'])
            ->whereHas('items')
            ->get();
        
        // Buat data pesanan dari cart items user
        $orders = [];
        foreach ($carts as $cart) {
            if ($cart->user && $cart->items && $cart->items->count() > 0) {
                $total = $cart->items->sum(function($item) {
                    return ($item->price ?? optional($item->product)->price ?? 0) * ($item->quantity ?? 0);
                });
                
                $productNames = $cart->items->map(function($item) {
                    return optional($item->product)->name ?? 'Produk';
                })->filter()->implode(', ');
                
                $orders[] = [
                    'id' => $cart->id,
                    'order_number' => 'CART-' . str_pad($cart->id, 6, '0', STR_PAD_LEFT),
                    'user_id' => $cart->user->id,
                    'user' => $cart->user,
                    'customer_name' => $cart->user->name,
                    'customer_email' => $cart->user->email,
                    'customer_phone' => $cart->user->email,
                    'products' => $productNames,
                    'items_count' => $cart->items->count(),
                    'total' => $total,
                    'status' => 'new',
                    'status_label' => 'Baru',
                    'created_at' => $cart->created_at ?? now(),
                    'is_cart' => true,
                ];
            }
        }
        
        // Ambil juga Order yang sudah ada dari database (jika ada)
        $dbOrders = Order::with(['customer', 'orderItems.product'])
            ->latest()
            ->get()
            ->map(function($order) {
                $productNames = $order->orderItems->map(function($item) {
                    return $item->product_name ?? optional($item->product)->name ?? 'Produk';
                })->filter()->implode(', ');
                
                $statusLabels = [
                    'new' => 'Baru',
                    'processing' => 'Diproses',
                    'shipped' => 'Dikirim',
                    'delivered' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                ];
                
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'user_id' => null,
                    'user' => null,
                    'customer_name' => $order->customer->name ?? 'Pelanggan',
                    'customer_email' => $order->customer->email ?? '',
                    'customer_phone' => $order->shipping_phone ?? $order->customer->phone ?? '',
                    'products' => $productNames,
                    'items_count' => $order->orderItems->count(),
                    'total' => $order->total,
                    'status' => $order->status,
                    'status_label' => $statusLabels[$order->status] ?? $order->status,
                    'created_at' => $order->order_date ?? $order->created_at,
                    'is_cart' => false,
                ];
            });
        
        // Gabungkan pesanan dari cart dan order
        $allOrders = collect(array_merge($orders, $dbOrders->toArray()))
            ->sortByDesc('created_at')
            ->values();
        
        // Hitung statistik
        $stats = [
            'new' => $allOrders->where('status', 'new')->count(),
            'processing' => $allOrders->where('status', 'processing')->count(),
            'shipped' => $allOrders->where('status', 'shipped')->count(),
            'delivered' => $allOrders->where('status', 'delivered')->count(),
            'cancelled' => $allOrders->where('status', 'cancelled')->count(),
        ];
        
        return view('dashboard.admin.orders.index', compact('allOrders', 'stats'));
    }
}
