<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('frontend.user.booking', compact('product'));
    }
    public function store(Request $request, $productId)
    {
       $product = Product::findOrFail($productId);

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
            'duration' => 'required|integer|min:1|max:4',
            'occasion' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
        ]);

        if ($product->stock <= 0) {
            return back()->with('error', 'Sorry, this archive is currently unavailable (Out of Stock).');
        }

        $totalPrice = $product->price * $request->duration;

        try {
            DB::transaction(function () use ($request, $product, $totalPrice) {
                
                Booking::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'start_date'  => $request->start_date, 
                    'end_date'    => $request->end_date,
                    'duration' => $request->duration,
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                    'occasion' => $request->occasion,
                    'venue' => $request->venue,
                ]);

                $product->decrement('stock', 1);
            });

            return redirect()->route('customer.rental.index')
                    ->with('success', 'Booking berhasil! Menunggu persetujuan admin.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->with('product')->latest()->paginate(5);;
        return view('frontend.user.rental', compact('bookings'));
    }
    public function showBooking($id)
    {
        $booking = Booking::with('product')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('frontend.user.rentaldetail', compact('booking'));
    }
    public function updateStatus(Request $request, $id, $status)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = $status;
        $booking->save();

        if ($status == 'approved') {
            $product = $booking->product;
            $product->is_available = false;
            $product->save();
        }
        
        if ($status == 'returned') {
            $product = $booking->product;
            $product->is_available = true;
            $product->save();
        }

        return back()->with('success', 'Status updated and product availability synchronized.');
    }
    public function DetailBooking($id)
    {
        $booking = Booking::with(['user', 'product'])->findOrFail($id);

        return view('frontend.admin.booking.detail', compact('booking'));
    }
}
