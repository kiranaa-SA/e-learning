<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $query = User::where('role', 'guru');
        $guru  = $query->get();

        // Tidak perlu munculkan alert warning di sini, karena tidak sedang menghapus
        return view('admin.guru.index', compact('guru', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.guru.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guru           = new User();
        $guru->name     = $request->name;
        $guru->email    = $request->email;
        $guru->foto     = $request->foto;
        $guru->password = Hash::make($request->password);
        $guru->role     = 'guru';

        if ($request->hasFile('foto')) {

            $img  = $request->file('foto');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('storage/guru', $name);
            $guru->foto = $name;
        }

        $guru->save();

        return redirect()->route('guru.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $guru = User::findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ], [
            'name.required'  => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email'    => 'Format email tidak valid',
            'email.unique'   => 'Email sudah terdaftar',

        ]);

        $guru        = User::findOrFail($id);
        $guru->name  = $request->name;
        $guru->email = $request->email;
        $guru->foto  = $request->foto;

        if ($request->filled('password')) {
            $guru->password = Hash::make($request->password);
        }
        if ($request->hasFile('foto')) {

            $img  = $request->file('foto');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('storage/guru', $name);
            $guru->foto = $name;
        }

        $guru->save();

        return redirect()->route('guru.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = User::findOrFail($id);

        // Menghapus data guru
        $guru->delete();

        // Redirect kembali dengan session sukses
        return redirect()->route('guru.index')->with('success', 'Data berhasil dihapus');
    }
}