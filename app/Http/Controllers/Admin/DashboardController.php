<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $salesToday = Order::whereDate(DB::raw('COALESCE(order_date, created_at)'), $today)->sum('total');
        $todayOrderCount = Order::whereDate(DB::raw('COALESCE(order_date, created_at)'), $today)->count();
        $totalOrders = Order::count();

        $topProduct = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->first();

        $recentOrders = Order::with(['customer', 'orderItems.product'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin.index', [
            'salesToday' => $salesToday,
            'todayOrderCount' => $todayOrderCount,
            'totalOrders' => $totalOrders,
            'topProduct' => $topProduct,
            'topProductName' => optional(optional($topProduct)->product)->name ?? 'Belum ada penjualan',
            'topProductQuantity' => optional($topProduct)->total_qty ?? 0,
            'recentOrders' => $recentOrders,
        ]);
    }
}
