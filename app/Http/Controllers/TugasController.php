<?php
namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tugas = Tugas::all();
        return view('admin.tugas.index', compact('tugas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tugas = Tugas::all();
        return view('admin.tugas.create', compact('tugas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'judul'       => 'required',
            'mapel'       => 'required',
            'jumlah_soal' => 'required',
            'soal_tugas'  => 'required',
        ]);

        $tugas              = new Tugas;
        $tugas->judul       = $request->judul;
        $tugas->mapel       = $request->mapel;
        $tugas->jumlah_soal = $request->jumlah_soal;
        $tugas->soal_tugas  = $request->soal_tugas;

        if ($request->hasFile('foto')) {
            $img  = $request->file('foto');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('storage/tugas', $name);
            $tugas->foto = $name;
        }

        $tugas->save();

        session()->flash('success', 'Data berhasil ditambahkan');

        return redirect()->route('admin.tugas.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tugas = Tugas::findOrFail($id);
        return view('admin.tugas.show', compact('tugas'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tugas = Tugas::findOrFail($id);
        return view('admin.tugas.edit', compact('tugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'judul'       => 'required',
            'mapel'       => 'required',
            'jumlah_soal' => 'required',
            'soal_tugas'  => 'required',
        ]);

        $tugas              = Tugas::findOrFail($id);
        $tugas->judul       = $request->judul;
        $tugas->mapel       = $request->mapel;
        $tugas->jumlah_soal = $request->jumlah_soal;
        $tugas->soal_tugas  = $request->soal_tugas;

        if ($request->hasFile('foto')) {
            $tugas->deleteImage();
            $img  = $request->file('foto');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('storage/tugas', $name);
            $tugas->foto = $name;
        }

        $tugas->save();
        session()->flash('success', 'Data Berhasil diedit');
        return redirect()->route('tugas.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();
        return redirect()->route('tugas.index');

    }
}
