<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            $rsetBarang = Barang::where('id', 'like', '%' . $searchTerm . '%')
                ->orWhere('merk', 'like', '%' . $searchTerm . '%')
                ->orWhere('seri', 'like', '%' . $searchTerm . '%')
                ->orWhere('spesifikasi', 'like', '%' . $searchTerm . '%')
                ->orWhere('stok', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('kategori', function ($query) use ($searchTerm) {
                    $query->where('kategori_id', 'like', '%' . $searchTerm . '%');
                })
                ->get();
        } else {
            $rsetBarang = Barang::all();
        }

        return view('v_barang.index', compact('rsetBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();

        $aKategori = [
            'blank' => 'Pilih Kategori',
            'M' => 'Barang Modal',
            'A' => 'Alat',
            'BHP' => 'Bahan Habis Pakai',
            'BTHP' => 'Bahan Tidak Habis Pakai'
        ];

        return view('v_barang.create', compact('aKategori', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merk' => 'required|unique:barang,merk',
            'seri' => 'required|unique:barang,seri',
            'spesifikasi' => 'required',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('barang.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        // Create post
        try {
            DB::beginTransaction(); // Mulai transaksi
    
            // Sisipkan data baru ke tabel kategori
            DB::table('barang')->insert([
                'merk' => $request->merk,
                'seri' => $request->seri,
                'spesifikasi' => $request->spesifikasi,
                'kategori_id' => $request->kategori_id,
            ]);
            DB::commit(); // Commit perubahan jika berhasil
        } catch (\Exception $e) {
            // Laporkan kesalahan
            report($e);
                
            // Rollback perubahan jika terjadi kesalahan
            DB::rollBack();
    
            // Kembali ke halaman pembuatan kategori dengan pesan error
            return redirect()->route('barang.create')->with([
                'error' => 'Terjadi kesalahan saat menyimpan data! Kesalahan: ' . $e->getMessage()
            ]);
        }

        // Redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);
        $deskripsiKategori = Barang::with('kategori')->where('id', $id)->first();
        return view('v_barang.show', compact('rsetBarang', 'deskripsiKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rsetBarang = Barang::find($id);
        $kategoriID = Kategori::all();
        
        return view('v_barang.edit', compact('rsetBarang', 'kategoriID'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'merk' => 'required|unique:barang,merk,' . $id,
            'seri' => 'required|unique:barang,seri,' . $id,
            'spesifikasi' => 'required',
            'stok' => 'required',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('barang.edit', $id)
                             ->withErrors($validator)
                             ->withInput();
        }

        $rsetBarang = Barang::find($id);
        $rsetBarang->update($request->all());

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (DB::table('barangmasuk')->where('barang_id', $id)->exists() || DB::table('barangkeluar')->where('barang_id', $id)->exists()) {
            return redirect()->route('barang.index')->with(['Gagal' => 'Gagal dihapus']);
        } else {
            $rsetBarang = Barang::find($id);
            $rsetBarang->delete();
            return redirect()->route('barang.index')->with(['Success' => 'Berhasil dihapus']);
        }
    }
}
