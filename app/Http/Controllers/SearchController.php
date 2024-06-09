<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $type = $request->input('type');

        if ($type === 'barang') {
            return $this->searchBarang($searchTerm);
        } elseif ($type === 'kategori') {
            return $this->searchKategori($searchTerm);
        } elseif ($type === 'barang_masuk') {
            return $this->searchBarangMasuk($searchTerm);
        } elseif ($type === 'barang_keluar') {
            return $this->searchBarangKeluar($searchTerm);
        } else {
            // Jenis pencarian tidak valid, redirect ke halaman sebelumnya atau berikan pesan kesalahan
            return redirect()->back()->withErrors(['Invalid search type']);
        }
    }

    private function searchBarang($searchTerm)
    {
        $rsetBarang = Barang::where('merk', 'like', '%' . $searchTerm . '%')
            ->orWhere('seri', 'like', '%' . $searchTerm . '%')
            ->orWhere('spesifikasi', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('kategori', function ($query) use ($searchTerm) {
                $query->where('id', 'like', '%' . $searchTerm . '%');
            })
            ->get();

        return view('v_barang.index', compact('rsetBarang'));
    }

    private function searchKategori($searchTerm)
    {
        $rsetKategori = Kategori::where('deskripsi', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->get();

        return view('v_kategori.index', compact('rsetKategori'));
    }

    private function searchBarangMasuk($searchTerm)
    {
        $rsetBarangMasuk = BarangMasuk::where('tgl_masuk', 'like', '%' . $searchTerm . '%')
            ->orWhere('qty_masuk', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('barang', function ($query) use ($searchTerm) {
                $query->where('id', 'like', '%' . $searchTerm . '%');
            })
            ->get();

        return view('v_barangmasuk.index', compact('rsetBarangMasuk'));
    }
    private function searchBarangKeluar($searchTerm)
    {
        $rsetBarangKeluar = BarangKeluar::where('tgl_keluar', 'like', '%' . $searchTerm . '%')
            ->orWhere('qty_keluar', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('barang', function ($query) use ($searchTerm) {
                $query->where('id', 'like', '%' . $searchTerm . '%');
            })
            ->get();
    
        return view('v_barangkeluar.index', compact('rsetBarangKeluar'));
    }
    
    
}
