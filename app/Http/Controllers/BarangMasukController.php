<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // $rsetBarang = Barang::latest()->paginate(10);
    //     // return view('v_barang.index',compact('rsetBarang'));

    //     // return view('vsiswa.index');
    //     $namaProduk = BarangMasuk::with('barang')->get();
    //     $rsetBarangMasuk = BarangMasuk::all();
    //     return view('v_barangmasuk.index',compact('rsetBarangMasuk'));
    // }
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
        $rsetBarangMasuk = BarangMasuk::where('tgl_masuk', 'like', '%' . $searchTerm . '%')
            ->orWhere('qty_masuk', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('barang', function ($query) use ($searchTerm) {
                $query->where('id', 'like', '%' . $searchTerm . '%');
            })
            ->get();
        } else {
            $rsetBarangMasuk = BarangMasuk::all();
        }

        return view('v_barangmasuk.index', compact('rsetBarangMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $aKategori = array('blank'=>'Pilih Kategori',
        //                     'M'=>'Barang Modal',
        //                     'A'=>'Alat',
        //                     'BHP'=>'Bahan Habis Pakai',
        //                     'BTHP'=>'Bahan Tidak Habis Pakai'
        //                     );
        $barangId = Barang::all();
        return view('v_barangmasuk.create',compact('barangId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate( [
            'tgl_masuk'              => 'required',
            'qty_masuk'              => 'required',
            'barang_id'       => 'required',
        ]);


        //create post
        try {
            DB::beginTransaction(); // Mulai transaksi
    
            // Sisipkan data baru ke tabel kategori
            DB::table('barangmasuk')->insert([
                'tgl_masuk' => $request->tgl_masuk,
                'qty_masuk' => $request->qty_masuk,
                'barang_id' => $request->barang_id,
            ]);
            DB::commit(); // Commit perubahan jika berhasil
        } catch (\Exception $e) {
            // Laporkan kesalahan
            report($e);
                
            // Rollback perubahan jika terjadi kesalahan
            DB::rollBack();
    
            // Kembali ke halaman pembuatan kategori dengan pesan error
            return redirect()->route('barangmasuk.create')->with([
                'error' => 'Terjadi kesalahan saat menyimpan data! Kesalahan: ' . $e->getMessage()
            ]);
        }

        //redirect to index
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarangMasuk = BarangMasuk::find($id);

        return view('v_barangmasuk.show', compact('rsetBarangMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $aKategori = array('blank'=>'Pilih Kategori',
        //                 'M'=>'Barang Modal',
        //                 'A'=>'Alat',
        //                 'BHP'=>'Bahan Habis Pakai',
        //                 'BTHP'=>'Bahan Tidak Habis Pakai'
        //             );

        $rsetBarangMasuk = BarangMasuk::find($id);
        $barangID = Barang::all();
        //return $rsetBarangMasuk;
        return view('v_barangmasuk.edit', compact('rsetBarangMasuk', 'barangID'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate( [
        'tgl_masuk' => 'required',
        'qty_masuk' => 'required',
        'barang_id' => 'required',
    ]);

    $rsetBarangMasuk = BarangMasuk::find($id);
    $rsetBarangMasuk->update($request->all());

    return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diubah!']);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarangMasuk = BarangMasuk::find($id);

        // Cek apakah ada BarangKeluar terkait dengan BarangMasuk ini
        $barangKeluarCount = BarangKeluar::where('barang_id', $rsetBarangMasuk->barang_id)
                                         ->where('tgl_keluar', '>=', $rsetBarangMasuk->tgl_masuk)
                                         ->count();

        if ($barangKeluarCount > 0) {
            return redirect()->route('barangmasuk.index')->with(['error' => 'Data tidak dapat dihapus karena sudah ada barang keluar yang terkait!']);
        }

        // Jika tidak ada, lanjutkan penghapusan
        $rsetBarangMasuk->delete();

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}