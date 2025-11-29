<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Ambil semua user dengan role 'user' (pelanggan)
        // Hitung total pembelian dari Cart items (total nilai barang di keranjang)
        $customers = User::where('role', 'user')
            ->with(['cart.items.product'])
            ->get()
            ->map(function ($user) {
                // Hitung total dari Cart items
                $totalSpent = 0;
                $totalItems = 0;
                
                if ($user->cart && $user->cart->items) {
                    $totalSpent = $user->cart->items->sum(function($item) {
                        $price = $item->price ?? optional($item->product)->price ?? 0;
                        $qty = $item->quantity ?? 0;
                        return $price * $qty;
                    });
                    $totalItems = $user->cart->items->sum('quantity');
                }
                
                // Untuk sementara, hitung dari Cart items
                // Nanti bisa dikembangkan untuk menghitung dari Order jika sudah ada sistem order
                $finalTotal = $totalSpent;
                $finalOrders = $totalItems > 0 ? 1 : 0;
                
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile_photo' => $user->profile_photo,
                    'created_at' => $user->created_at,
                    'total_orders' => $finalOrders,
                    'total_spent' => $finalTotal,
                ];
            })
            ->sortByDesc('total_spent')
            ->values();

        // Hitung statistik
        $stats = [
            'total' => $customers->count(),
            'with_orders' => $customers->filter(function($c) {
                return $c['total_orders'] > 0;
            })->count(),
            'total_revenue' => $customers->sum('total_spent'),
        ];

        return view('dashboard.admin.customers.index', compact('customers', 'stats'));
    }
}
