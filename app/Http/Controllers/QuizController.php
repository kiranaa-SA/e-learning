<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\SoalQuiz;
use App\Models\Mapel;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quiz = Quiz::all();
        $mapel = Mapel::all();
        return view('admin.quiz.index', compact('quiz','mapel'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mapel = Mapel::all();
        return view('admin.quiz.create', compact('mapel'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'waktu_pengerjaan' => 'required|integer|min:1',
        'tenggat_waktu' => 'required|date',
        'id_mapel' => 'required|exists:mapels,id',
        'jumlah_soal' => 'required|integer|min:1',
        'soal' => 'required|array|min:1',
        'opsi' => 'required|array',
        'jawaban_benar' => 'required|array'
    ]);

    // Generate Kode Quiz
    $lastQuiz = Quiz::latest('id')->first();
    $lastId = $lastQuiz ? $lastQuiz->id : 0;
    $kodeQuiz = 'QUIZ-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    // Buat quiz
    $quiz = Quiz::create([
        'kode_quiz' => $kodeQuiz,
        'judul' => $request->judul,
        'id_mapel' => $request->id_mapel,
        'jumlah_soal' => $request->jumlah_soal,
        'waktu_pengerjaan' => $request->waktu_pengerjaan,
        'tenggat_waktu' => $request->tenggat_waktu,
    ]);

    // Simpan soal
    foreach ($request->soal as $i => $pertanyaan) {
        SoalQuiz::create([
            'quiz_id' => $quiz->id,
            'pertanyaan' => $pertanyaan,
            'pilihan_a' => $request->opsi[$i]['A'] ?? '',
            'pilihan_b' => $request->opsi[$i]['B'] ?? '',
            'pilihan_c' => $request->opsi[$i]['C'] ?? '',
            'pilihan_d' => $request->opsi[$i]['D'] ?? '',
            'jawaban_benar' => $request->jawaban_benar[$i] ?? 'A',
        ]);
    }

    return redirect()->route('quiz.index')->with('success', 'Quiz berhasil dibuat!');
}





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('admin.quiz.show', compact('quiz'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
{
    $mapel = Mapel::all();
    $soal = $quiz->soal()->get();
    return view('admin.quiz.edit', compact('quiz', 'soal','mapel'));
}

public function update(Request $request, Quiz $quiz)
{
    $request->validate([
        'judul' => 'required',
        'waktu_pengerjaan' => 'required|integer|min:1',
        'tenggat_waktu' => 'required|date',
        'soal' => 'required|array',
        'opsi' => 'required|array',
        'jawaban_benar' => 'required|array'
    ]);

    $quiz->update([
        'judul' => $request->judul,
        'id_mapel' => $request->id_mapel,
        'waktu_pengerjaan' => $request->waktu_pengerjaan,
        'tenggat_waktu' => $request->tenggat_waktu,
    ]);

    foreach ($quiz->soal as $i => $soal) {
        $soal->update([
            'pertanyaan' => $request->soal[$i],
            'pilihan_a' => $request->opsi[$i]['A'],
            'pilihan_b' => $request->opsi[$i]['B'],
            'pilihan_c' => $request->opsi[$i]['C'],
            'pilihan_d' => $request->opsi[$i]['D'],
            'jawaban_benar' => $request->jawaban_benar[$i],
        ]);
    }

    return redirect()->route('quiz.index')->with('success', 'Quiz berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return redirect()->route('quiz.index')->with('success', 'Quiz berhasil dihapus.');
    }
}
