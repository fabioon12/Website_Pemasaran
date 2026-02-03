<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
   public function index(Request $request)
    {
        $query = Product::query()
            ->withCount('bookings') 
            ->where('is_published', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }
        if ($request->filled('occasion')) {
            $query->where('occasion', $request->occasion);
        }
        if ($request->filled('materials')) {
            $query->where('materials', $request->materials);
        }
        if ($request->filled('year')) {
            $query->where('year_made', $request->year);
        }


        $products = $query->latest()->paginate(5);

        $colors = Product::distinct()->pluck('color')->filter()->sort();
        $occasions = Product::distinct()->pluck('occasion')->filter()->sort();
        $materials = Product::distinct()->pluck('materials')->filter()->sort(); 
        $years = Product::distinct()->pluck('year_made')->filter()->sortDesc();

        $products = $query->paginate(5);

        return view('frontend.user.catalog', compact('products', 'colors', 'occasions', 'materials', 'years'));
    }
}