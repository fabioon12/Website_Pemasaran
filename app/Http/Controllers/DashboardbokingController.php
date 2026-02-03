<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class DashboardbokingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'product']);

     
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
           
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }

                $q->orWhereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                });

        
                $q->orWhereHas('product', function($productQuery) use ($search) {
                    $productQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        }

      
        $bookings = $query->latest()->paginate(5)->withQueryString();
        
       
        $totalBookings = Booking::count();
        $totalRevenue = Booking::whereIn('status', ['approved', 'returned'])->sum('total_price');
        $pendingCount = Booking::where('status', 'pending')->count();

        return view('frontend.admin.booking.index', compact(
            'bookings', 
            'totalBookings', 
            'totalRevenue', 
            'pendingCount'
        ));
    }

    public function updateStatus($id, $status)
    {
        $booking = Booking::with('product')->findOrFail($id);
        $oldStatus = $booking->status;

        $allowedStatuses = ['pending', 'approved', 'rejected', 'returned'];
        if (!in_array($status, $allowedStatuses)) {
            return back()->with('error', 'Invalid status update.');
        }

        if ($oldStatus === $status) {
            return back()->with('info', 'Status is already ' . strtoupper($status));
        }

        DB::transaction(function () use ($booking, $status, $oldStatus) {
            
            if ($status == 'approved' && $oldStatus == 'pending') {
                $booking->product->increment('wear_count');
            }

            if ($status == 'rejected' && $oldStatus == 'pending') {
                $booking->product->increment('stock', 1);
            }

            if ($status == 'returned' && $oldStatus == 'approved') {
                $booking->product->increment('stock', 1);
            }

            $booking->update(['status' => $status]);
        });

        return back()->with('success', 'Booking #' . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . ' updated to ' . strtoupper($status));
    }
    public function DetailBooking($id)
    {
        $booking = Booking::with(['user', 'product'])->findOrFail($id);

        return view('frontend.admin.booking.detail', compact('booking'));
    }
}