@extends('layouts.adm-main')

@section('content')
@php $pageType = 'dashboard'; @endphp
    <!-- Content Row -->
    <div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <a href="{{ route('barang.index') }}" style="text-decoration: none; color: inherit;">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Barang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $barang }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <a href="{{ route('kategori.index') }}" style="text-decoration: none; color: inherit;">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Kategori</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kategori }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    </a>
</div>


<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <a href="{{ route('barangmasuk.index') }}" style="text-decoration: none; color: inherit;">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Barang Masuk
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $barangMasuk }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    </a>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <a href="{{ route('barangkeluar.index') }}" style="text-decoration: none; color: inherit;">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Barang Keluar</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $barangKeluar }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <a>
</div>

</div>

<!-- Content Row -->
@endsection