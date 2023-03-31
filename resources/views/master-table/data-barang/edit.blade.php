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
            <h2 class="section-title">Update Data Barang</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('data-barang.update', $dataBarang) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Admin</label>
                            <input type="text" id="admin_id" name="admin_id" class="form-control @error('admin_id') is-invalid @enderror"
                            placeholder="Masukan Admin" value="{{ old('admin_id', $dataBarang->admin_id) }}" data-id="input_admin_id">
                            @error('admin_id')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror "
                            placeholder="Masukan Nama Barang" value="{{ old('nama_barang', $dataBarang->nama_barang) }}" data-id="input_nama_barang">
                            @error('nama_barang')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <select class="form-control select2 @error('jenis_barang_id') is-invalid @enderror"
                                    id="jenis_barang_id" name="jenis_barang_id" data-id="select-jenis_barang_id">
                                    <option value="">Pilih Jenis Barang</option>
                                    @foreach ($jenisBarangs as $jenisBarang)
                                        <option @selected($jenisBarang->id == $dataBarang->jenis_barang_id) value="{{ $jenisBarang->id }}">
                                            {{ $jenisBarang->jenis_barang }}
                                        </option>
                                    @endforeach
                                </select>
                            @error('jenis_barang_id')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Barang</label>
                            <input type="text" id="harga_barang" name="harga_barang" class="form-control @error('harga_barang') is-invalid @enderror"
                            placeholder="Masukan Harga Barang" value="{{ old('harga_barang', $dataBarang->harga_barang) }}" data-id="input_harga_barang">
                            @error('harga_barang')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity"
                                placeholder="Masukkan Quantity" value="{{ old('quantity', $dataBarang->quantity) }}" data-id="quantity">
                            @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tersedia">Tersediaan</label>
                            <input type="text" class="form-control @error('tersedia') is-invalid @enderror" id="tersedia" name="tersedia"
                                placeholder="Masukkan Tersediaan"  value="{{ old('tersedia', $dataBarang->tersedia) }}" data-id="tersedia">
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
