<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\RuangMateri;
use App\Models\SubMateri;
use App\Models\Quiz;

class SubmateriController extends Controller
{
public function index($materi_id)
    {
        $materi = RuangMateri::findOrFail($materi_id);
        $subMateris = SubMateri::where('ruang_materi_id', $materi_id)->orderBy('urutan', 'asc')->get();
        
        return view('frontend.admin.submateri.index', compact('materi', 'subMateris'));
    }

    // Form Tambah
    public function create($materi_id)
    {
        $materi = RuangMateri::findOrFail($materi_id);
        return view('frontend.admin.submateri.create', compact('materi'));
    }

    // Proses Simpan
    public function store(Request $request, $materi_id)
    {
        // 1. Validasi Dasar
        $request->validate([
            'judul' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'file_pdf' => 'nullable|mimes:pdf|max:10000',
            'video_url' => 'nullable|url',
        ]);

        // 2. Simpan Data Sub-Materi Utama
        $subMateri = new SubMateri();
        $subMateri->ruang_materi_id = $materi_id;
        $subMateri->judul = $request->judul;
        $subMateri->durasi = $request->durasi;
        $subMateri->urutan = $request->urutan; 
        $subMateri->konten = $request->konten; 
        $subMateri->video_url = $request->video_url;

        // Upload Thumbnail
        if ($request->hasFile('thumbnail')) {
            $subMateri->thumbnail = $request->file('thumbnail')->store('thumbnails/sub-materi', 'public');
        }

        // Upload PDF
        if ($request->hasFile('file_pdf')) {
            $subMateri->file_pdf = $request->file('file_pdf')->store('documents/pdf', 'public');
        }

        $subMateri->save();

        // 3. Simpan Kuis (Disesuaikan dengan Nama Kolom Migration: kunci_jawaban)
        if ($request->has('q_text')) {
            foreach ($request->q_text as $index => $text) {
                $quiz = new Quiz();
                $quiz->sub_materi_id = $subMateri->id;
                $quiz->pertanyaan_teks = $text;
                
                // SESUAIKAN DENGAN MIGRATION KAMU: kunci_jawaban
                if (isset($request->q_correct_ans[$index])) {
                    $quiz->kunci_jawaban = $request->q_correct_ans[$index];
                }

                // Simpan Gambar Pertanyaan
                if ($request->hasFile("q_img.$index")) {
                    $quiz->pertanyaan_gambar = $request->file("q_img")[$index]->store('quiz/questions', 'public');
                }

                // Simpan Opsi Jawaban A, B, C, D (Teks & Gambar)
                foreach (['a', 'b', 'c', 'd'] as $opt) {
                    $txtFieldName = "q_opt_{$opt}";
                    $imgFieldName = "q_opt_img_{$opt}";
                    
                    // Ambil data teks opsi
                    $quiz->{"jawaban_{$opt}_teks"} = $request->input($txtFieldName)[$index] ?? null;

                    // Ambil data gambar opsi jika ada
                    if ($request->hasFile("$imgFieldName.$index")) {
                        $quiz->{"jawaban_{$opt}_gambar"} = $request->file($imgFieldName)[$index]->store("quiz/options", 'public');
                    }
                }

                $quiz->save();
            }
        }

        return redirect()->route('admin.submateri.index', $materi_id)
                        ->with('success', 'Sub-Materi dan Kuis berhasil ditambahkan!');
    }
    public function edit($materi_id, $id)
    {
        $materi = RuangMateri::findOrFail($materi_id);
        $subMateri = SubMateri::with('quizzes')->findOrFail($id);
        
        return view('frontend.admin.submateri.edit', compact('materi', 'subMateri'));
    }
    // Proses Update
    public function update(Request $request, $materi_id, $id)
    {
        // 1. Validasi
        $request->validate([
            'judul' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'file_pdf' => 'nullable|mimes:pdf|max:10000',
            'video_url' => 'nullable|url',
        ]);

        $subMateri = SubMateri::findOrFail($id);

        // 2. Update Data Dasar
        $subMateri->judul = $request->judul;
        $subMateri->durasi = $request->durasi;
        $subMateri->urutan = $request->urutan;
        $subMateri->konten = $request->konten;
        $subMateri->video_url = $request->video_url;

        // Update Thumbnail (Hapus yang lama jika ada upload baru)
        if ($request->hasFile('thumbnail')) {
            if($subMateri->thumbnail) Storage::disk('public')->delete($subMateri->thumbnail);
            $subMateri->thumbnail = $request->file('thumbnail')->store('thumbnails/sub-materi', 'public');
        }

        // Update PDF (Hapus yang lama jika ada upload baru)
        if ($request->hasFile('file_pdf')) {
            if($subMateri->file_pdf) Storage::disk('public')->delete($subMateri->file_pdf);
            $subMateri->file_pdf = $request->file('file_pdf')->store('documents/pdf', 'public');
        }

        $subMateri->save();

        // 3. Update Kuis
        // Hapus kuis lama untuk menghindari duplikasi saat pengeditan dinamis
        if ($request->has('q_text')) {
            // Opsional: Hapus file gambar kuis lama di sini jika ingin hemat storage
            $subMateri->quizzes()->delete(); 

            foreach ($request->q_text as $index => $text) {
                $quiz = new Quiz();
                $quiz->sub_materi_id = $subMateri->id;
                $quiz->pertanyaan_teks = $text;

                // Gambar Pertanyaan
                if (isset($request->file('q_img')[$index])) {
                    $quiz->pertanyaan_gambar = $request->file('q_img')[$index]->store('quiz/questions', 'public');
                } elseif ($request->has('old_q_img') && isset($request->old_q_img[$index])) {
                    // Jika tidak upload baru, gunakan path gambar lama (disimpan di input hidden)
                    $quiz->pertanyaan_gambar = $request->old_q_img[$index];
                }

                // Opsi Jawaban
                foreach (['a', 'b', 'c', 'd'] as $opt) {
                    $txtField = "q_opt_{$opt}";
                    $imgField = "q_opt_img_{$opt}";
                    $oldImgField = "old_q_opt_img_{$opt}";
                    
                    $quiz->{"jawaban_{$opt}_teks"} = $request->$txtField[$index] ?? null;

                    if (isset($request->file($imgField)[$index])) {
                        $quiz->{"jawaban_{$opt}_gambar"} = $request->file($imgField)[$index]->store("quiz/options", 'public');
                    } elseif ($request->has($oldImgField) && isset($request->$oldImgField[$index])) {
                        $quiz->{"jawaban_{$opt}_gambar"} = $request->$oldImgField[$index];
                    }
                }
                $quiz->save();
            }
        }

        return redirect()->route('admin.submateri.index', $materi_id)
                         ->with('success', 'Sub-Materi berhasil diperbarui!');
    }
    // Proses Hapus
    public function destroy($materi_id, $id)
    {
        $subMateri = SubMateri::findOrFail($id);
        $materi_id = $subMateri->ruang_materi_id;

        // Hapus file fisik
        if($subMateri->thumbnail) Storage::disk('public')->delete($subMateri->thumbnail);
        if($subMateri->file_pdf) Storage::disk('public')->delete($subMateri->file_pdf);
        
        // Hapus kuis terkait (gambar kuis juga harus dihapus di produksi yang lebih advance)
        $subMateri->delete();

        return redirect()->route('admin.submateri.index', $materi_id)
                     ->with('success', 'Sub-Materi dan seluruh kuis terkait berhasil dihapus.');
    }
}
