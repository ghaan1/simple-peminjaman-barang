@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Data Rusak - Perbaikan</h1>
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
                                <option value="diperbaiki"
                                    {{ 'diperbaiki' ? 'selected' : '' }}>
                                    DIPERBAIKI</option>
                            </select>
                            @error('status_rusak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity_rusak">Quantity</label>
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
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('perbaikan.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    {{-- <script>
        jQuery(document).ready(function() {
            $('#role').change(function() {
                if ($(this).val() == '') {
                    $('#user_id').attr('disabled', true);
                } else {
                    $('#user_id').removeAttr('disabled', false);
                }
                let roleId = $(this).val();
                $.ajax({
                    url: '{{ route('get-user-role') }}',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        id: roleId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        console.log(data);
                        $('#user_id').html('<option value="">Pilih Nama User</option>');
                        $.each(data['userRole'], function(index, val) {
                            console.log('<option value="' + val.id + '"> ' + val
                                .name + ' </option>');
                            $('#user_id').append('<option value="' + val.id +
                                '"> ' + val
                                .name +
                                ' </option>')
                        });
                    }
                });
            });
        });
    </script>
    <script>
        jQuery(document).ready(function() {
            $('#user_id').change(function() {
                if ($(this).val() == '') {
                    $('#barang_id').attr('disabled', true);
                } else {
                    $('#barang_id').removeAttr('disabled', false);
                }
                let userId = $(this).val();
                $.ajax({
                    url: '{{ route('get-barang-peminjam') }}',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        id: userId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        console.log(data);
                        $('#barang_id').html('<option value="">Pilih Nama Barang</option>');
                        $.each(data['dataPeminjaman'], function(index, val) {
                            if (val.peminjam_id == userId) {
                                console.log('<option value="' + val.id + '"> ' +
                                    val
                                    .nama_barang + ' </option>');
                                $('#barang_id').append('<option value="' + val.id +
                                    '"> ' + val
                                    .nama_barang +
                                    ' </option>')
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#barang_id').change(function() {
                var barangId = $(this).val();
                var quantity = getDataBarangQuantity(barangId);
                $('#quantity-info').text('Quantity: ' + quantity);
                if (barangId == '') {
                    $('#quantity-info').hide();
                    $('#quantity-tersedia').hide();
                } else {
                    $('#quantity-info').show();
                    $('#quantity-tersedia').show();
                }
            });


            function getDataBarangQuantity(barangId) {
                $.ajax({
                    url: '{{ route('get-data-barang-quantity') }}',
                    method: 'POST',
                    data: {
                        barang_id: barangId
                    },
                    success: function(databarang) {
                        console.log(databarang.databarang['quantity']);
                        console.log(databarang.databarang['tersedia']);
                        var quantity = databarang.databarang['quantity'];
                        var quantityTersedia = databarang.databarang['tersedia'];
                        $('#quantity-tersedia').text('Quantity Total: ' + quantity);
                        $('#quantity-info').text('Quantity Yang Tidak Dipinjam: ' + quantityTersedia);


                        $('#quantity_rusak').on('input', function() {
                            var enteredQuantity = parseInt($(this).val());
                            if (enteredQuantity > quantityTersedia) {
                                $(this).addClass('is-invalid');
                                $(this).siblings('.invalid-feedback').text(
                                    'Quantity melebihi yang tersedia');
                            } else {
                                $(this).removeClass('is-invalid');
                                $(this).siblings('.invalid-feedback').empty();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
    </script> --}}
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
