@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Data Peminjaman</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="#" method="post">
                        @csrf
                        @if (in_array(
                                'super-admin',
                                Auth::user()->roles->pluck('name')->toArray()))
                            <div class="form-group">
                                <label>Nama Peminjam</label>
                                <select name="nama_peminjam" class="form-control select2">
                                    <option value="">Nama Peminjam</option>
                                </select>
                                @error('jenis-barang')
                                    {{ $message }}
                                @enderror
                            </div>
                        @endif


                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <select name="jenis_barang" class="form-control select2">
                                <option value="">Jenis Barang</option>
                            </select>
                            @error('jenis-barang')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select name="nama_barang" class="form-control select2">
                                <option value="">Nama Barang</option>
                            </select>
                            @error('nama-barang')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="quantity"
                                placeholder="Masukkan Quantity">
                            @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pinjam">Tanggal Pinjam</label>
                            <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                id="tanggal_pinjam" name="tanggal_pinjam">
                            @error('tanggal_pinjam')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('data-peminjaman.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
