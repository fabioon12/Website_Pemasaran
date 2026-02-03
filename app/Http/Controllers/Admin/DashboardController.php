<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Booking; 


class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Booking::where('status', 'approved')->sum('total_price');
        $totalBookings = Booking::count();
        $pendingCount = Booking::where('status', 'pending')->count();
        $productsCount = Product::count();

    
        $recentBookings = Booking::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();

      
        $lowStockProducts = Product::where('stock', '<', 5)
            ->take(4)
            ->get();

   
        return view('frontend.admin.dashboard', compact(
            'totalRevenue', 
            'totalBookings', 
            'pendingCount', 
            'productsCount', 
            'recentBookings', 
            'lowStockProducts'
        ));
    }
}
