<?php
namespace App\Http\Controllers;

use App\Models\NilaiTugas;
use App\Models\JawabanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTugasController extends Controller
{
    public function index()
    {
        $tugas = Tugas::all();
        return view('user.tugas.index', compact('tugas'));
    }

    // Form pengerjaan tugas
    public function kerjakan($id)
    {
        $tugas = Tugas::with('soal')->findOrFail($id);
        if (now()->gt($tugas->tenggat_waktu)) {
        return redirect()->back()->with('error', 'Tugas sudah lewat tenggat waktu.');
    }
        return view('user.tugas.kerjakan', compact('tugas'));
    }

    // Menyimpan hasil pengerjaan
    public function submit(Request $request, $id)
    {
        $tugas = Tugas::with('soal')->findOrFail($id);
        $jawabanUser = $request->jawaban;
        $benar = 0;
        $totalSoal = $tugas->soal->count();


        foreach ($tugas->soal as $soal) {
            $jawaban = $jawabanUser[$soal->id] ?? null;
            if ($jawaban && $jawaban === $soal->jawaban_benar) {
                $benar++;
            }
        }

        if ($totalSoal == 0) {
            $nilai = 0;
        } else {
            $nilai = ($benar / $totalSoal) * 100;
        }

        NilaiTugas::create([
            'id_user' => Auth::id(),
            'id_tugas' => $tugas->id,
            'nilai' => $nilai,
        ]);
        foreach ($tugas->soal as $soal) {
        $jawaban   = $jawabanUser[$soal->id] ?? null;
        $isCorrect = $jawaban === $soal->jawaban_benar;

        JawabanTugas::create([
            'id_user'  => Auth::id(),
            'id_tugas' => $tugas->id,
            'id_soal'  => $soal->id,
            'jawaban'  => $jawaban,
            'benar'    => $isCorrect,
        ]);

        if ($isCorrect) {
            $benar++;
        }
    }

        return redirect()->route('user.tugas.hasil', $tugas->id)->with('success', 'Nilai Anda: ' . $nilai);
    }


    // Melihat hasil
    public function hasil($id)
    {
        $hasil = NilaiTugas::where('id_user', Auth::id())->where('id_tugas', $id)->firstOrFail();
        return view('user.tugas.hasil', compact('hasil'));
    }
}