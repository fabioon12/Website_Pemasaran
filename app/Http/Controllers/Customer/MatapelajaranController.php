<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangMateri;
use App\Models\Quiz;
use App\Models\SubMateri;

class MatapelajaranController extends Controller
{
    public function index()
    {
        $materis = RuangMateri::withCount('subMateris')
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('frontend.user.matapelajaran.index', compact('materis'));
    }
    public function show($id)
    {
        $materi = RuangMateri::with(['subMateris' => function($query) {
            $query->orderBy('urutan', 'asc');
        }])->findOrFail($id);

        return view('frontend.user.matapelajaran.show', compact('materi'));
    }
    public function belajar($materi_id, $id) 
    {
        $subMateri = SubMateri::with(['quizzes', 'ruangMateri'])->findOrFail($id);

        if (auth()->check()) {
            auth()->user()->subMaterisSelesai()->syncWithoutDetaching([$id]);
        }
        
        $allSub = SubMateri::where('ruang_materi_id', $materi_id)
                            ->orderBy('urutan', 'asc')
                            ->get();

        return view('frontend.user.matapelajaran.belajar', compact('subMateri', 'allSub'));
        
    }
}
