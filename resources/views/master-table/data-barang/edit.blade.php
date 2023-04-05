@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Data Barang</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Edit Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('data-barang.update', $dataBarang) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group" style="display:none;">
                            <label>Admin</label>
                            <input type="text" id="admin_id" name="admin_id"
                                class="form-control @error('admin_id') is-invalid @enderror" placeholder="Masukan Admin"
                                value="{{ old('admin_id', $dataBarang->admin_id) }}" data-id="input_admin_id"
                                autocomplete="off">
                            @error('admin_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <select class="form-control select2 @error('jenis_barang_id') is-invalid @enderror"
                                id="jenis_barang_id" name="jenis_barang_id" data-id="select-jenis_barang_id">
                                <option value="">Pilih Jenis Barang</option>
                                @foreach ($jenisBarangs as $jenisBarang)
                                    <option @selected($jenisBarang->id == $dataBarang->jenis_barang_id) value="{{ $jenisBarang->id }}">
                                        {{ $jenisBarang->kode_jb }}-{{ $jenisBarang->jenis_barang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_barang_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang"
                                class="form-control @error('nama_barang') is-invalid @enderror "
                                placeholder="Masukan Nama Barang" value="{{ old('nama_barang', $dataBarang->nama_barang) }}"
                                data-id="input_nama_barang" autocomplete="off">
                            @error('nama_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group" style="display:none;">
                            <label>Kode Jenis Barang</label>
                            <input type="text" id="kode_jenis_barang" name="kode_jbs"
                                class="form-control @error('kode_jbs') is-invalid @enderror"
                                placeholder="Masukan Kode Jenis Barang" autocomplete="off"
                                value="{{ old('kode_jb', $dataBarang->kode_jb) }}">
                            @error('kode_jbs')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Barang</label>
                            <input type="text" id="harga_barang" name="harga_barang"
                                class="form-control @error('harga_barang') is-invalid @enderror"
                                placeholder="Masukan Harga Barang"
                                value="{{ old('harga_barang', $dataBarang->harga_barang) }}" data-id="input_harga_barang"
                                autocomplete="off">
                            @error('harga_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" placeholder="Masukkan Quantity"
                                value="{{ old('quantity', $dataBarang->quantity) }}" data-id="quantity" autocomplete="off">
                            @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group" style="display:none;">
                            <label for="tersedia">Tersediaan</label>
                            <input type="text" class="form-control @error('tersedia') is-invalid @enderror"
                                id="tersedia" name="tersedia" placeholder="Masukkan Tersediaan"
                                value="{{ old('tersedia', $dataBarang->tersedia) }}" data-id="tersedia" autocomplete="off">
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
