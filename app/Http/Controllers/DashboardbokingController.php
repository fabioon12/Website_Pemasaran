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

                $cleanId = preg_replace('/[^0-9]/', '', $search); 

                if (is_numeric($cleanId)) {
                    $q->where('id', $cleanId);
                    
                    $q->orWhereHas('user', function($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
                } else {
                 
                    $q->whereHas('user', function($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('product', function($productQuery) use ($search) {
                        $productQuery->where('name', 'like', '%' . $search . '%');
                    });
                }
            });
        }

      
        $bookings = $query->latest()->paginate(5)->withQueryString();
        
       
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');
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

        $allowedStatuses = ['pending', 'approved', 'rejected', 'returned', 'paid'];
        if (!in_array($status, $allowedStatuses)) {
            return back()->with('error', 'Invalid status update.');
        }

        DB::transaction(function () use ($booking, $status, $oldStatus) {
         
            if ($status == 'paid') {
                $booking->update([
                    'payment_status' => 'paid'
                ]);
            
                if($booking->status == 'pending') {
                    $booking->update(['status' => 'approved']);
                }
            } else {
                // Logika Increment/Decrement yang sudah Anda buat
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
            }
        });

        return back()->with('success', 'Status updated successfully.');
    }
    public function DetailBooking($id)
    {
        $booking = Booking::with(['user', 'product'])->findOrFail($id);

        return view('frontend.admin.booking.detail', compact('booking'));
    }
}