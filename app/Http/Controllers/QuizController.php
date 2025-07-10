<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\SoalQuiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quiz = Quiz::all();
        return view('admin.quiz.index', compact('quiz'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'waktu_pengerjaan' => 'required|integer|min:1',
            'tenggat_waktu' => 'required|date',
            'jumlah_soal' => 'required|integer|min:1',
            'soal' => 'required|array',
            'opsi' => 'required|array',
            'jawaban_benar' => 'required|array'
        ]);

        $lastQuiz = Quiz::latest('id')->first();
        $lastId = $lastQuiz ? $lastQuiz->id : 0;
        $kodeQuiz = 'QUIZ-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $quiz = Quiz::create([
            'kode_quiz' => $kodeQuiz,
            'judul' => $request->judul,
            'jumlah_soal' => $request->jumlah_soal,
            'waktu_pengerjaan' => $request->waktu_pengerjaan,
            'tenggat_waktu' => $request->tenggat_waktu,
        ]);

        foreach ($request->soal as $i => $soalText) {
            SoalQuiz::create([
                'quiz_id' => $quiz->id,
                'pertanyaan' => $soalText,
                'pilihan_a' => $request->opsi[$i]['A'],
                'pilihan_b' => $request->opsi[$i]['B'],
                'pilihan_c' => $request->opsi[$i]['C'],
                'pilihan_d' => $request->opsi[$i]['D'],
                'jawaban_benar' => $request->jawaban_benar[$i],
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
        return view('quiz.show', compact('quiz'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quiz  = Quiz::findOrFail($id);
        return view('admin.quiz.edit', compact('quiz',));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 
    }
}
