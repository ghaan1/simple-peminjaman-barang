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
                    <form action="{{ route('data-barang.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Admin</label>
                            <input type="text" id="admin_id" name="admin_id" class="form-control @error('admin_id') is-invalid @enderror"
                            placeholder="Masukan Admin">
                            @error('admin_id')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                            placeholder="Masukan Nama Barang">
                            @error('nama_barang')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <select class="form-control select2 @error('jenis_barang_id') is-invalid @enderror" name="jenis_barang_id"
                            data-id="select-jenis-barang" id="jenis_barang_id">
                            <option value="">Piih Jenis Barang</option>
                            @foreach ($jenisBarangs as $jenisBarang)
                                <option value="{{ $jenisBarang->id }}">
                                    {{ $jenisBarang->jenis_barang }} </option>
                            @endforeach
                        </select>
                            @error('jenis_barang_id')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Barang</label>
                            <input type="text" id="harga_barang" name="harga_barang" class="form-control @error('harga_barang') is-invalid @enderror"
                            placeholder="Masukan Harga Barang">
                            @error('harga_barang')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity"
                                placeholder="Masukkan Quantity">
                            @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tersedia">Tersediaan</label>
                            <input type="text" class="form-control @error('tersedia') is-invalid @enderror" id="tersedia" name="tersedia"
                                placeholder="Masukkan Tersediaan">
                            @error('tersedia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('data-barang.index') }}">Cancel</a>
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
