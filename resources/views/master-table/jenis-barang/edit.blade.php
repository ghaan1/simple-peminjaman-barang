@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah Jenis Barang</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Ubah Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jenis-barang.update', $jenisBarang) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kode Jenis Barang</label>
                            <input type="text" id="kode_jb" name="kode_jb"
                                class="form-control
                                @error('kode_jb') is-invalid @enderror"
                                placeholder="Masukan Jenis Barang" value="{{ old('kode_jb', $jenisBarang->kode_jb) }}"
                                data-id="input_kode_jb" autocomplete="off">
                            @error('kode_jb')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <input type="text" id="jenis_barang" name="jenis_barang"
                                class="form-control
                                @error('jenis_barang') is-invalid @enderror"
                                placeholder="Masukan Jenis Barang"
                                value="{{ old('jenis_barang', $jenisBarang->jenis_barang) }}" data-id="input_jenis_barang"
                                autocomplete="off">
                            @error('jenis_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('jenis-barang.index') }}">Batal</a>
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
