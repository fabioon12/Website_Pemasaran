<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\RuangMateri;

class MateriController extends Controller
{
   public function index()
    {
        $materis = RuangMateri::latest()->paginate(10);
        
        // Data Statistik sederhana untuk Card di View
        $stats = [
            'total_materi' => RuangMateri::count(),
            'total_views'  => RuangMateri::sum('views'),
            'total_kategori' => RuangMateri::distinct('kategori')->count(),
            'total_sub'    => 0 // Nantinya bisa dihitung dari relasi sub-materi
        ];

        return view('frontend.admin.materi.index', compact('materis', 'stats'));
    }

    /**
     * Form Tambah Materi
     */
    public function create()
    {
        return view('frontend.admin.materi.create');
    }

    /**
     * Simpan Materi Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|max:255',
            'kategori'  => 'required',
            'deskripsi' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 'published' : 'draft';
        $data['slug'] = Str::slug($request->judul);

        // Handle Upload Thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails/materi', 'public');
        }

        RuangMateri::create($data);

        return redirect()->route('admin.ruang-materi.index')
                         ->with('success', 'Materi berhasil ditambahkan!');
    }

    /**
     * Form Edit Materi
     */
    public function edit($id)
    {
        $materi = RuangMateri::findOrFail($id);
        return view('frontend.admin.materi.edit', compact('materi'));
    }

    /**
     * Update Materi
     */
    public function update(Request $request, $id)
    {
        $materi = RuangMateri::findOrFail($id);

        $request->validate([
            'judul'     => 'required|max:255',
            'kategori'  => 'required',
            'deskripsi' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 'published' : 'draft';
        $data['slug'] = Str::slug($request->judul);

        if ($request->hasFile('thumbnail')) {
            // Hapus foto lama jika ada
            if ($materi->thumbnail) {
                Storage::disk('public')->delete($materi->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails/materi', 'public');
        }

        $materi->update($data);

        return redirect()->route('admin.ruang-materi.index')
                         ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Hapus Materi
     */
    public function destroy($id)
    {
        $materi = RuangMateri::findOrFail($id);

        // Hapus file thumbnail dari storage
        if ($materi->thumbnail) {
            Storage::disk('public')->delete($materi->thumbnail);
        }

        $materi->delete();

        return redirect()->route('admin.ruang-materi.index')
                         ->with('success', 'Materi berhasil dihapus!');
    }
}
