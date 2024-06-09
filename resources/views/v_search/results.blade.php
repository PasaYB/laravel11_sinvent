<!-- resources/views/v_search/results.blade.php -->

@extends('layouts.adm-main')

@section('content')
<div class="container">
    @if(isset($rsetBarang) && $rsetBarang->count() > 0)
        <table class="table">
            <h3>Barang</h3>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Merk</th>
                    <th>Seri</th>
                    <th>Spesifikasi</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rsetBarang as $barang)
                    <tr>
                        <td>{{ $barang->id }}</td>
                        <td>{{ $barang->merk }}</td>
                        <td>{{ $barang->seri }}</td>
                        <td>{{ $barang->spesifikasi }}</td>
                        <td>{{ $barang->stok }}</td>
                        <td>{{ $barang->kategori->id }} - {{ $barang->kategori->deskripsi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @if(isset($rsetKategori) && $rsetKategori->count() > 0)
        <table class="table">
        <h3>Kategori</h3>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rsetKategori as $kategori)
                    <tr>
                        <td>{{ $kategori->id }}</td>
                        <td>{{ $kategori->deskripsi }}</td>
                        <td>{{ $kategori->kategori  }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
