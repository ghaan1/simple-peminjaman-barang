@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Barang Rusak</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Data Barang Perbaikan</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('perbaikan.update', $perbaikan) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="tanggal_perbaikan">Tanggal Perbaikan</label>
                            <input type="date" class="form-control @error('tanggal_perbaikan') is-invalid @enderror"
                                id="tanggal_perbaikan" name="tanggal_perbaikan"
                                value="{{ old('tanggal_perbaikan', $perbaikan->tanggal_perbaikan) }}">
                            @error('tanggal_perbaikan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama User</label>
                            <select name="user_id" class="form-control select2" disabled>
                                <option value="">Nama User</option>
                                @foreach ($users as $listUser)
                                    <option value="{{ $listUser->id }}"
                                        {{ old('user_id', $dataRusak->user_id) == $listUser->id ? 'selected' : '' }}>
                                        {{ $listUser->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select name="barang_id" class="form-control select2 @error('barang_id') is-invalid @enderror"
                                id="barang_id" disabled>
                                <option value="">Nama Barang</option>
                                @foreach ($dataBarang as $listBarang)
                                    <option value="{{ $listBarang->id }}"
                                        {{ old('barang_id', $dataRusak->barang_id) == $listBarang->id ? 'selected' : '' }}>
                                        {{ $listBarang->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status_rusak">Status</label>
                            <select class="form-control select2" name="status_rusak" id="status_rusak">
                                <option value=""
                                    {{ old('status_rusak', $dataRusak->status_rusak) === '' ? 'selected' : '' }}>
                                    Pilih Status</option>
                                <option value="rusak">
                                    RUSAK</option>
                                <option value="diperbaiki" {{ 'diperbaiki' ? 'selected' : '' }}>
                                    DIPERBAIKI</option>
                            </select>
                            @error('status_rusak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity_rusak">Jumlah Kerusakan</label>
                            <input type="text" class="form-control @error('quantity_rusak') is-invalid @enderror"
                                id="quantity_rusak" name="quantity_rusak"
                                value="{{ old('quantity_rusak', $dataRusak->quantity_rusak) }}"
                                placeholder="Masukkan Quantity" autocomplete="off" readonly>
                            @error('quantity_rusak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="quantity_perbaikan">Jumlah Diperbaiki</label>
                            <input type="text" class="form-control @error('quantity_perbaikan') is-invalid @enderror"
                                id="quantity_perbaikan" name="quantity_perbaikan"
                                value="{{ old('quantity_perbaikan', $dataRusak->quantity_perbaikan) }}"
                                placeholder="Masukkan Quantity" autocomplete="off">
                            @error('quantity_perbaikan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        


                        <div class="row">
                            <div class="form-group col-md-6 col-12" id="foto_upload_form">
                                <div class="form-group">
                                    <label>Unggah Bukti</label>
                                    <input name="bukti_perbaikan" type="file"
                                        class="form-control @error('bukti_perbaikan') is-invalid @enderror">
                                    @error('bukti_perbaikan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12" id="foto_upload_form">
                                <div class="form-group">
                                    <label>Unggah KTP</label>
                                    <input name="ktp_perbaikan" type="file"
                                        class="form-control @error('ktp_perbaikan') is-invalid @enderror">
                                    @error('ktp_perbaikan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('perbaikan.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#status_rusak').change(function() {
                if ($(this).val() == 'diperbaiki') {
                    $('#quantity_perbaikan').parent().show();
                } else {
                    $('#quantity_perbaikan').parent().hide();
                }
            }).trigger('change'); 
        });
        </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
