@extends('layouts.adm-main')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('barangkeluar.create') }}" class="btn btn-md btn-success">TAMBAH BARANG KELUAR</a>
                        <form action="/barangkeluar" method="GET" class="d-flex">
                                @csrf
                        <div class="input-group">
                         <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                </div>
            </form>
                    </div>
                </div>
            </div>
                @if(session('Success'))
                    <div class="alert alert-success">
                        {{ session('Success') }}
                    </div>
                @endif

                @if(session('Gagal'))
                    <div class="alert alert-danger">
                        {{ session('Gagal') }}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal Keluar</th>
                            <th>Quantity</th>
                            <th>ID - Merk Barang</th>
                            <th style="width: 15%">AKSI</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rsetBarangKeluar as $rowbarangkeluar)
                            <tr>
                                <td>{{ $rowbarangkeluar->id  }}</td>
                                <td>{{ $rowbarangkeluar->tgl_keluar  }}</td>
                                <td>{{ $rowbarangkeluar->qty_keluar  }}</td>
                                <td>{{ $rowbarangkeluar->barang_id  }} - {{ $rowbarangkeluar->barang->merk }}</td>
                                <td class="text-center"> 
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barangkeluar.destroy', $rowbarangkeluar->id) }}" method="POST">
                                        <a href="{{ route('barangkeluar.show', $rowbarangkeluar->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('barangkeluar.edit', $rowbarangkeluar->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                                
                            </tr>
                        @empty
                            <div class="alert">
                                Data belum tersedia
                            </div>
                        @endforelse
                    </tbody>
                    
                </table>
                {{-- {{ $siswa->links() }} --}}

            </div>
        </div>
    </div>
@endsection