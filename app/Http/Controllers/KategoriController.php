<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class KategoriController extends Controller
{
    // public function index(Request $request)
    // {
        
    //     //return $rsetKategori;
    //     if ($request->search){
    //         $rsetKategori = DB::table('kategori')->select('id','deskripsi',DB::raw('getKategori(kategori) as kat'))
    //                                              ->where('id','like','%'.$request->search.'%')
    //                                              ->orWhere('deskripsi','like','%'.$request->search.'%')
    //                                              ->paginate(10);
    //     }else {
    //         $rsetKategori = DB::table('kategori')->select('id','deskripsi',DB::raw('getKategori(kategori) as kat'))->paginate(10);
    //     }
    //     //return $request->search;
    //     return view('v_kategori.index',compact('rsetKategori'));
      
    // }
    public function index(Request $request)
    {
        if ($request->search) {
            $rsetKategori = DB::table('kategori')
                            ->select('id', 'deskripsi', DB::raw('getKategori(kategori) as kat'))
                            ->where('id', 'like', '%' . $request->search . '%')
                            ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                            ->orWhere('kategori', 'like', '%' . $request->search . '%')
                            ->paginate(10);
        } else {
            $rsetKategori = DB::table('vKategori')
                            ->select('id', 'deskripsi','kat')
                            ->paginate(10);
        }
        return view('v_kategori.index', compact('rsetKategori'));
    }
    public function create()
    {
        $akategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Modal Barang',
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
        // Validasi input
        $request->validate([
            'deskripsi' => 'required',
            'kategori' => 'required',
        ]);
    
        // Periksa apakah entri sudah ada
        $exists = Kategori::where('deskripsi', $request->deskripsi)
                          ->where('kategori', $request->kategori)
                          ->exists();
    
        if ($exists) {
            return redirect()->route('kategori.create')->with(['error' => 'Deskripsi dan Kategori sudah ada!']);
        }
    
        // Buat entri baru dalam transaksi
        try {
            DB::beginTransaction(); // Mulai transaksi
    
            // Sisipkan data baru ke tabel kategori
            DB::table('kategori')->insert([
                'deskripsi' => $request->deskripsi,
                'kategori' => $request->kategori,
            ]);
    
            DB::commit(); // Commit perubahan jika berhasil
        } catch (\Exception $e) {
            // Laporkan kesalahan
            report($e);
    
            // Rollback perubahan jika terjadi kesalahan
            DB::rollBack();
    
            // Kembali ke halaman pembuatan kategori dengan pesan error
            return redirect()->route('kategori.create')->with([
                'error' => 'Terjadi kesalahan saat menyimpan data! Kesalahan: ' . $e->getMessage()
            ]);
        }
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    // {
    //     $rsetKategori = Kategori::find($id);
    //     return view('v_kategori.show', compact('rsetKategori'));
    // }
    // {
    //     $rsetKategori = DB::table('kategori')
    //         ->select('id', 'deskripsi', DB::raw('getKategori(kategori) as kat'))
    //         ->where('id', $id)
    //         ->first();
    
    //     return view('v_kategori.show', compact('rsetKategori'));
    // }
    {
        // $rsetKategori = DB::select('call getKategoriById(?)',[$id]);
        
        // return view('v_kategori.show', compact('rsetKategori'));
        $rsetKategori = DB::selectOne('call getKategoriById(?)', [$id]);
        return view('v_kategori.show', compact('rsetKategori'));

    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $akategori = array(
            'blank' => 'Pilih Kategori',
            'M' => 'M - Modal Barang',
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
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $rsetKategori = Kategori::where('deskripsi', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->get();
    
        return view('v_kategori.index', compact('rsetKategori'));
    }
    
    

}

