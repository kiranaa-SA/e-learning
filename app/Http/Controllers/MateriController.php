<?php
namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materi = Materi::all();
        $mapel  = Mapel::all();
        $kelas  = Kelas::all();
        return view('admin.materi.index', compact('materi', 'mapel', 'kelas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.materi.create', compact('mapel', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string',
            'isi_materi' => 'required',
            'id_mapel'   => 'required',
            'id_kelas'   => 'required',
        ]);

        $materi             = new Materi();
        $materi->judul      = $request->judul;
        $materi->isi_materi = $request->isi_materi;
        $materi->id_mapel   = $request->id_mapel;
        $materi->id_kelas   = $request->id_kelas;

        $materi->save();

        return redirect()->route('materi.index')->with('success', 'materi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $materi = Materi::findOrFail($id);
        return view('admin.materi.show', compact('materi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $materi = Materi::findOrFail($id);
        $mapel  = Mapel::all();
        $kelas  = Kelas::all();
        return view('admin.materi.edit', compact('materi', 'mapel', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi_materi' => 'required',
            'id_mapel' => 'required',
            'id_kelas' => 'required',
        ]);

        $materi        = Materi::findOrFail($id);
        $materi->judul = $request->judul;
        $materi->isi_materi = $request->isi_materi;
        $materi->id_mapel = $request->id_mapel;
        $materi->id_kelas = $request->id_kelas;

        $materi->save();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
