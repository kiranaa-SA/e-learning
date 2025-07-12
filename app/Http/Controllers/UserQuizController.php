<?php
namespace App\Http\Controllers;

use App\Models\JawabanQuiz;
use App\Models\NilaiQuiz;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserQuizController extends Controller
{
    public function index()
    {
        $quiz = Quiz::all();
        return view('user.quiz.index', compact('quiz'));
    }

    // Form pengerjaan quiz
    public function kerjakan($id)
    {
        $quiz = Quiz::with('soal')->findOrFail($id);
        if (now()->gt($quiz->tenggat_waktu)) {
            return redirect()->back()->with('error', 'Quiz sudah lewat tenggat waktu.');
        }

        return view('user.quiz.kerjakan', compact('quiz'));
    }

    // Menyimpan hasil pengerjaan
    public function submit(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jawaban'   => 'required|array',
            'jawaban.*' => 'required|in:A,B,C,D',
        ]);

        $quiz        = Quiz::with('soal')->findOrFail($id);
        $jawabanUser = $request->jawaban;
        $benar       = 0;
        $totalSoal   = $quiz->soal->count();

        // Cek apakah user sudah pernah mengerjakan quiz ini
        $existingNilai = NilaiQuiz::where('id_user', Auth::id())
            ->where('id_quiz', $quiz->id)
            ->first();

        if ($existingNilai) {
            return redirect()->route('user.quiz.hasil', $quiz->id)
                ->with('info', 'Anda sudah mengerjakan quiz ini sebelumnya.');
        }

        // Proses setiap jawaban
        foreach ($quiz->soal as $soal) {
            $jawabanTerpilih = $jawabanUser[$soal->id] ?? null;
            $isCorrect       = $jawabanTerpilih && $jawabanTerpilih === $soal->jawaban_benar;

            // Simpan jawaban user
            JawabanQuiz::create([
                'id_user' => Auth::id(),
                'id_quiz' => $quiz->id,
                'id_soal' => $soal->id,
                'jawaban' => $jawabanTerpilih,
                'benar'   => $isCorrect,
            ]);

            // Hitung jawaban benar
            if ($isCorrect) {
                $benar++;
            }
        }

        // Hitung nilai
        $nilai = ($totalSoal == 0) ? 0 : ($benar / $totalSoal) * 100;

        // Simpan nilai quiz
        NilaiQuiz::create([
            'id_user' => Auth::id(),
            'id_quiz' => $quiz->id,
            'nilai'   => $nilai,
        ]);

        return redirect()->route('user.quiz.hasil', $quiz->id)
            ->with('success', 'Quiz berhasil diselesaikan! Nilai Anda: ' . round($nilai, 2));
    }

    // Melihat hasil
    public function hasil($id)
    {
        $hasil = NilaiQuiz::where('id_user', Auth::id())
            ->where('id_quiz', $id)
            ->with('quiz')
            ->firstOrFail();

        return view('user.quiz.hasil', compact('hasil'));
    }
}
