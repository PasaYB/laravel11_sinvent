<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $rsetKategori = Kategori::latest()->paginate(10);
        // return view('v_Kategori.index',compact('rsetKategori'));

        // return view('vsiswa.index');

        $rsetKategori = Kategori::all();
        return view('v_kategori.index',compact('rsetKategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Kategori Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );
        return view('v_kategori.create',compact('akategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required',
            'kategori' => 'required',
        ]);

        $exists = Kategori::where('deskripsi', $request->deskripsi)
                          ->where('kategori', $request->kategori)
                          ->exists();

        if ($exists) {
            return redirect()->route('kategori.create')->with(['error' => 'Deskripsi dan Kategori sudah ada!']);
        }

        // Create post
        Kategori::create([
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ]);

        // Redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetKategori = Kategori::find($id);
        return view('v_kategori.show', compact('rsetKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $akategori = array(
            'blank' => 'Pilih Kategori',
            'M' => 'M - Modal',
            'A' => 'A - Alat',
            'BHP' => 'BHP - Bahan Habis Pakai',
            'BTHP' => 'BTHP - Bahan Tidak Habis Pakai'
        );

        $rsetKategori = Kategori::find($id);
        return view('v_kategori.edit', compact('rsetKategori', 'akategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'deskripsi' => 'required',
            'kategori' => 'required',
        ]);

        $exists = Kategori::where('deskripsi', $request->deskripsi)
                          ->where('kategori', $request->kategori)
                          ->where('id', '!=', $id)
                          ->exists();

        if ($exists) {
            return redirect()->route('kategori.edit', $id)->with(['error' => 'Deskripsi dan Kategori sudah ada!']);
        }

        $rsetKategori = Kategori::find($id);
        $rsetKategori->update($request->all());

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (DB::table('barang')->where('kategori_id', $id)->exists()) {
            return redirect()->route('kategori.index')->with(['Gagal' => 'Gagal dihapus']);
        } else {
            $rsetKategori = Kategori::find($id);
            $rsetKategori->delete();
            return redirect()->route('kategori.index')->with(['Success' => 'Berhasil dihapus']);
        }
    }

}