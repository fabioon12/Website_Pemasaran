<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
      $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                // Mencari berdasarkan ID (exact match)
                if (is_numeric($search)) {
                    $q->where('id', $search);
                }
                
                // Atau mencari berdasarkan Nama (partial match)
                $q->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        $totalPublished = Product::where('is_published', true)->count();
        $totalDraft = Product::where('is_published', false)->count();

        return view('frontend.admin.produk.index', compact('products', 'totalPublished', 'totalDraft'));
    }

    public function create()
    {
        return view('frontend.admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'author'         => 'nullable|string|max:255',
            'price'          => 'required|numeric',
            'stock'          => 'required|integer',
            'images'         => 'required|array|min:1|max:3', // Pastikan images adalah array
            'images.*'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'year_made'      => 'nullable|integer',
            'is_published'   => 'nullable',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
            
                if ($image) {
                    $images[] = $image->store('products', 'public');
                }
            }
        }

        Product::create([
            'name'            => $request->name,
            'author'          => $request->author,
            'description'     => $request->description,
            'year_made'       => $request->year_made,
            'color'           => $request->color,
            'occasion'        => $request->occasion,
            'measure_bust'    => $request->measure_bust,
            'measure_waist'   => $request->measure_waist,
            'measure_hip'     => $request->measure_hip,
            'measure_length'  => $request->measure_length,
            'price'           => $request->price,
            'materials'       => $request->materials,
            'stock'           => $request->stock,
            'is_published'    => $request->boolean('is_published'), 
            'images'          => $images,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('frontend.admin.produk.update', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric',
            'stock'    => 'required|integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

  
        $data = $request->except('images'); 
        $data['is_published'] = $request->boolean('is_published');


        $currentImages = is_string($product->images) ? json_decode($product->images, true) : ($product->images ?? []);

  
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $newFile) {
                if ($newFile) {
       
                    if (isset($currentImages[$index]) && Storage::disk('public')->exists($currentImages[$index])) {
                        Storage::disk('public')->delete($currentImages[$index]);
                    }

         
                    $path = $newFile->store('products', 'public');

            
                    $currentImages[$index] = $path;
                }
            }
            
            // Urutkan array berdasarkan kunci agar tetap rapi (0, 1, 2)
            ksort($currentImages);
            $data['images'] = array_values($currentImages);
        }

        $product->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }
    public function destroy($id)
    {
       $products = Product::all();
        foreach ($products as $p) {
            if ($p->images) {
                $images = is_string($p->images) ? json_decode($p->images, true) : $p->images;
                foreach ($images as $img) {
                    Storage::disk('public')->delete($img);
                }
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate(); 
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('admin.produk.index')->with('success', 'Data produk berhasil dihapus');
        }
}