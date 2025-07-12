<?php
// app/Http/Controllers/StudentTugasController.php
namespace App\Http\Controllers;

use App\Models\NilaiTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JawabanTugasController extends Controller
{
    /**
     * Display a listing of available tugas for students.
     */
    public function index()
    {
        $userId = Auth::id();

        // Get all tugas with their completion status
        $tugas = Tugas::with('mapel')->get()->map(function ($item) use ($userId) {
            $item->is_completed = NilaiTugas::where('id_user', $userId)
                ->where('id_tugas', $item->id)
                ->exists();
            $item->nilai = NilaiTugas::where('id_user', $userId)
                ->where('id_tugas', $item->id)
                ->first()?->nilai;
            return $item;
        });

        return view('tugass', compact('tugas'));
    }

    /**
     * Show the form for doing the tugas.
     */
    public function show($id)
    {
        $tugas  = Tugas::with(['soal', 'mapel'])->findOrFail($id);
        $userId = Auth::id();

        // Check if user has already completed this tugas
        $sudahSelesai = NilaiTugas::where('id_user', $userId)
            ->where('id_tugas', $id)
            ->exists();

        if ($sudahSelesai) {
            $nilai = NilaiTugas::where('id_user', $userId)
                ->where('id_tugas', $id)
                ->first();
            return view('student.tugas.result', compact('tugas', 'nilai'));
        }

        return view('student.tugas.show', compact('tugas'));
    }

    /**
     * Store the answers and calculate the score.
     */
    public function submit(Request $request, $id)
    {
        $tugas  = Tugas::with('soal')->findOrFail($id);
        $userId = Auth::id();

        // Check if user has already completed this tugas
        $sudahSelesai = NilaiTugas::where('id_user', $userId)
            ->where('id_tugas', $id)
            ->exists();

        if ($sudahSelesai) {
            return redirect()->route('student.tugas.show', $id)
                ->with('error', 'Anda sudah menyelesaikan tugas ini!');
        }

        $request->validate([
            'jawaban'   => 'required|array',
            'jawaban.*' => 'required|in:A,B,C,D',
        ]);

        $totalSoal    = $tugas->soal->count();
        $jawabanBenar = 0;

        // Calculate correct answers
        foreach ($tugas->soal as $index => $soal) {
            if (isset($request->jawaban[$soal->id]) &&
                $request->jawaban[$soal->id] == $soal->jawaban_benar) {
                $jawabanBenar++;
            }
        }

        // Calculate score (correct answers / total questions * 100)
        $nilai = ($jawabanBenar / $totalSoal) * 100;

        // Save the score
        NilaiTugas::create([
            'id_user'  => $userId,
            'id_tugas' => $id,
            'nilai'    => round($nilai, 2),
        ]);

        return redirect()->route('student.tugas.show', $id)
            ->with('success', 'Tugas berhasil diselesaikan! Nilai Anda: ' . round($nilai, 2));
    }

    /**
     * Show results for completed tugas.
     */
    public function result($id)
    {
        $tugas  = Tugas::with('mapel')->findOrFail($id);
        $userId = Auth::id();

        $nilai = NilaiTugas::where('id_user', $userId)
            ->where('id_tugas', $id)
            ->first();

        if (! $nilai) {
            return redirect()->route('student.tugas.index')
                ->with('error', 'Anda belum menyelesaikan tugas ini!');
        }

        return view('student.tugas.result', compact('tugas', 'nilai'));
    }
}
