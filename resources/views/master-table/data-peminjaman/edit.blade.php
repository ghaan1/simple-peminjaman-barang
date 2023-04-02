@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Data Peminjaman</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Edit Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('data-peminjaman.update', $dataPeminjaman) }}" method="post">
                        @csrf
                        @method('PUT')
                        @if (in_array(
                                'super-admin',
                                Auth::user()->roles->pluck('name')->toArray()))
                            <div class="form-group">
                                <label>Nama Peminjam</label>
                                <select name="peminjam_id" class="form-control select2">
                                    <option value="">Nama Peminjam</option>
                                    @foreach ($user as $listUser)
                                        <option value="{{ $listUser->id }}"
                                            {{ old('peminjam_id', $dataPeminjaman->peminjam_id) == $listUser->id ? 'selected' : '' }}>
                                            {{ $listUser->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('peminjam_id')
                                    {{ $message }}
                                @enderror
                            </div>
                        @else
                            <div class="form-group">
                                <label>Nama Peminjam</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                <input type="hidden" name="peminjam_id" value="{{ Auth::user()->id }}">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="jenis_barang_id">Jenis Barang</label>
                            <select name="jenis_barang_id" class="form-control select2" id="jenis_barang_id">
                                <option value="">Pilih Jenis Barang</option>
                                @foreach ($jenisBarang as $listJenisBarang)
                                    <option value="{{ $listJenisBarang->id }}"
                                        {{ old('jenis_barang_id', $dataPeminjaman->jenis_barang_id) == $listJenisBarang->id ? 'selected' : '' }}>
                                        {{ $listJenisBarang->jenis_barang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_barang_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select name="barang_id" class="form-control select2" id="barang_id">
                                <option value="">Nama Barang</option>
                            </select>
                            @error('nama-barang')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" value="{{ old('quantity', $dataPeminjaman->quantity) }}"
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
                                id="tanggal_pinjam" name="tanggal_pinjam"
                                value="{{ old('tanggal_pinjam', $dataPeminjaman->tanggal_pinjam) }}">
                            @error('tanggal_pinjam')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group" hidden>
                            <label for="status">Status</label>
                            <input type="text" class="form-control @error('status') is-invalid @enderror" id="status"
                                name="status" value="{{ old('status', $dataPeminjaman->status) }}">
                            @error('status')
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
    <script>
        jQuery(document).ready(function() {
            $('#jenis_barang_id').change(function() {
                if ($(this).val() == '') {
                    $('#barang_id').attr('disabled', true);
                } else {
                    $('#barang_id').removeAttr('disabled', false);
                }
                let jenis_barang_id = $(this).val();
                var selectBarang = "{{ $dataBarang }}"
                var dataBarangItem = JSON.parse(selectBarang.replace(/&quot;/g, '"'));
                console.log(dataBarangItem);
                $.ajax({
                    url: '{{ route('data-peminjaman-barang.filters') }}',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        id: jenis_barang_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#barang_id').html('<option value="">Pilih Nama Barang</option>');
                        $.each(dataBarangItem, function(index, val) {
                            if (val.jenis_barang_id == jenis_barang_id) {
                                console.log('<option value="' + val.id + '"> ' + val
                                    .nama_barang + ' </option>');
                                $('#barang_id').append('<option value="' + val.id +
                                    '"> ' + val
                                    .nama_barang + ' (Stok : ' + val.tersedia +
                                    '  )' +
                                    ' </option>')
                            }
                        });
                    }

                });
            });

            var selectDataBarang = "{{ $dataBarang }}";
            var dataBarang = JSON.parse(selectDataBarang.replace(/&quot;/g, '"'));
            var selectedDataPeminjamanJenisBarang = ({{ $dataPeminjaman->jenis_barang_id }});
            $.ajax({
                url: '{{ route('data-peminjaman-barang-get.filters') }}',
                type: 'get',
                data: {
                    id: selectedDataPeminjamanJenisBarang
                },
                success: function(data) {
                    console.log(dataBarang);
                    $('#barang_id').empty();
                    var formBarangID = $('#barang_id');
                    formBarangID.empty();
                    $.each(dataBarang, function(index, val) {
                        if (val.jenis_barang_id == selectedDataPeminjamanJenisBarang) {
                            console.log('<option value="' + val.id + '"> ' + val
                                .nama_barang + ' </option>')
                            $("#barang_id option[value='" + val.id + "']").attr(
                                "selected", "selected");
                            formBarangID.append('<option value="' + val.id + '"> ' + val
                                .nama_barang + ' (Stok : ' + val.tersedia +
                                '  )' +
                                ' </option>')
                        }
                    });
                }
            });
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
