@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Data Peminjaman</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis-barang.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Kode Jenis Barang</label>
                            <input type="text" id="kode_jb" name="kode_jb"
                                class="form-control @error('kode_jb') is-invalid @enderror"
                                placeholder="Kode Jenis Barang" autocomplete="off">
                            @error('kode_jb')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <input type="text" id="jenis_barang" name="jenis_barang"
                                class="form-control @error('jenis_barang') is-invalid @enderror"
                                placeholder="Masukan Jenis Barang" autocomplete="off">
                            @error('jenis_barang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('jenis-barang.index') }}">Cancel</a>
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
