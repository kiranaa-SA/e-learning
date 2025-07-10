<?php
namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelas.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'kelas' => 'required|unique:kelas',
        //  ]);

        $kelas        = new Kelas();
        $kelas->kelas = $request->kelas;

        $kelas->save();
        session()->flash('success', 'data berhasil disimpan');
        return redirect()->route('kelas.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('kelas.edit', compact('kelas'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $validated = $request->validate([
//     'kelas' => 'required|unique:kelas',
//  ]);

        $kelas        = Kelas::findOrFail($id);
        $kelas->kelas = $request->kelas;

        $kelas->save();
        session()->flash('success', 'data berhasil disimpan');
        return redirect()->route('kelas.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Data berhasil dihapus');

    }
}
