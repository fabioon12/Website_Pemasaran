<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
   public function index(Request $request)
    {
        $query = Product::query()->where('is_published', true);

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


        $publishedOnly = Product::where('is_published', true);

        $colors = (clone $publishedOnly)->distinct()->pluck('color')->filter()->sort();
        $occasions = (clone $publishedOnly)->distinct()->pluck('occasion')->filter()->sort();
        $materials = (clone $publishedOnly)->distinct()->pluck('materials')->filter()->sort(); 
        $years = (clone $publishedOnly)->distinct()->pluck('year_made')->filter()->sortDesc();

        $products = $query->paginate(12);

        return view('frontend.user.catalog', compact('products', 'colors', 'occasions', 'materials', 'years'));
    }
}