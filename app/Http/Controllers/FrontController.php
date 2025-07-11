<?php
namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Tugas;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kelas untuk ditampilkan di filter
        $kelas = Kelas::all();

        $quiz = Quiz::all();
        $query = User::where('role', 'guru');
        $guru  = $query->get();

        // Ambil materi berdasarkan kelas yang dipilih
        if ($request->has('search')) {
            $materi = Materi::where('id_kelas', $request->get('search'))->get();
        } else {
            $materi = Materi::all(); // Ambil semua materi jika tidak ada filter
        }
        

        return view('welcome', compact('materi', 'kelas','guru','quiz'));
    }
    public function quizz(Request $request)  {
        $quiz = Quiz::all();
        $kelas = Kelas::all();


                return view('quizz', compact('quiz','kelas'));
     }

    public function tugass(){
        $tugas = Tugas::all();
        $kelas = Kelas::all();

        return view('tugass', compact('tugas','kelas'));
    }
}
