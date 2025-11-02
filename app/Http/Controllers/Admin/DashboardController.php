<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Get real statistics from database
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        
        // Calculate total revenue (only from delivered orders)
        $totalRevenue = Order::whereIn('status', [Order::STATUS_DELIVERED_SUCCESSFULLY])->sum('total');
        
        // Calculate monthly revenue (current month)
        $monthlyRevenue = Order::whereIn('status', [Order::STATUS_DELIVERED_SUCCESSFULLY])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        
        // Calculate previous month data for percentage changes
        $prevMonthProducts = Product::whereMonth('created_at', '<', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $productChange = $prevMonthProducts > 0 ? round((($totalProducts - $prevMonthProducts) / $prevMonthProducts) * 100) : 0;
        
        $prevMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $currentMonthOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $orderChange = $prevMonthOrders > 0 ? round((($currentMonthOrders - $prevMonthOrders) / $prevMonthOrders) * 100) : 0;
        
        $prevMonthRevenue = Order::whereIn('status', [Order::STATUS_DELIVERED_SUCCESSFULLY])
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total');
        $revenueChange = $prevMonthRevenue > 0 ? round((($monthlyRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100) : 0;
        
        // Get recent orders (last 5)
        $recentOrders = Order::with('items')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $data = [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'productChange' => $productChange,
            'orderChange' => $orderChange,
            'revenueChange' => $revenueChange,
            'recentOrders' => $recentOrders,
        ];

        return view('admin.dashboard', $data);
    }
}
