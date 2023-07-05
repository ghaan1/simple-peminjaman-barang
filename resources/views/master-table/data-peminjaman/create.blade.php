@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Data Peminjaman</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Data Peminjaman</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('data-peminjaman.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Nama Peminjam</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                            <input type="hidden" name="peminjam_id" value="{{ Auth::user()->id }}">
                        </div>
                        {{-- @endif --}}
                        <div class="form-group">
                            <label>Jenis Barang</label>
                            <select name="jenis_barang_id"
                                class="form-control select2 @error('jenis_barang_id') is-invalid @enderror"
                                id="jenis_barang_id">
                                <option value="">Pilih Jenis Barang</option>
                                @foreach ($jenisBarang as $listJenisBarang)
                                    <option value="{{ $listJenisBarang->id }}">
                                        {{ $listJenisBarang->jenis_barang }} </option>
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
                            <select name="barang_id" class="form-control select2 @error('barang_id') is-invalid @enderror"
                                id="barang_id" disabled="disable">
                                <option value="">Nama Barang</option>
                                {{-- @foreach ($dataBarang as $listJenisBarang)
                                    <option value="{{ $listJenisBarang->id }}"
                                        data-jenis="{{ $listJenisBarang->jenis_barang }}">
                                        {{ $listJenisBarang->nama_barang }}
                                    </option>
                                @endforeach --}}
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Jumlah</label>
                            <input type="text" name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                placeholder="Masukkan Quantity" autocomplete="off">
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
                        <div class="form-group" hidden>
                            <label for="status">Status</label>
                            <input type="text" class="form-control @error('status') is-invalid @enderror" id="status"
                                name="status" value="Sedang Dipinjam">
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="show_ktp" id="show_ktp"
                                        {{ old('show_ktp') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_ktp">
                                        Ambil Dari Database?
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <div class="mt-2" id="ktp_preview"
                                    style="{{ Auth::user()->profile && Auth::user()->profile->ktp ? 'display: none' : 'display: block' }}"
                                    name="ktp_review">
                                    <h6 id="headerKTP" style="display: none">Preview KTP:</h6>
                                    @if (Auth::user()->profile && Auth::user()->profile->ktp)
                                        <img src="{{ asset('storage/' . Auth::user()->profile->ktp) }}" alt="KTP Preview"
                                            width="200">
                                    @else
                                        <p id="ktp_message" style="display: none">Tidak ada KTP, Isi Dulu Di Profile</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-12" id="ktp_upload_form"
                                style="{{ old('show_ktp') ? 'display: none' : 'display: block' }}">
                                <div class="form-group">
                                    <label>Unggah KTP</label>
                                    <input name="ktp_peminjam" type="file"
                                        class="form-control @error('ktp_peminjam') is-invalid @enderror">
                                    @error('ktp_peminjam')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" id="submitBtn">Kirim</button>
                            <a class="btn btn-secondary" href="{{ route('data-peminjaman.index') }}">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script>
        // Get the checkbox element, submit button element, and KTP message element
        const checkbox = document.getElementById('show_ktp');
        const submitBtn = document.getElementById('submitBtn');
        const ktpMessage = document.getElementById('ktp_message');

        // Add event listener for the checkbox
        checkbox.addEventListener('change', function() {
            // Disable or enable the submit button based on the checkbox state and KTP message existence
            if (checkbox.checked && ktpMessage && ktpMessage.textContent === "Tidak ada KTP, Isi Dulu Di Profile") {
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        });
    </script>
    <script>
        document.getElementById('show_ktp').addEventListener('change', function() {
            var ktpUploadForm = document.getElementById('ktp_upload_form');
            var ktpPreview = document.getElementById('ktp_preview');
            var ktpMessage = document.getElementById('ktp_message');
            var headerKTP = document.getElementById('headerKTP');
            if (this.checked) {
                ktpUploadForm.style.display = 'none';
                ktpPreview.style.display = 'block';
                ktpMessage.style.display = 'block';
                headerKTP.style.display = 'block';
            } else {
                ktpUploadForm.style.display = 'block';
                ktpPreview.style.display = 'none';
                ktpMessage.style.display = 'none';
                headerKTP.style.display = 'none';
            }
        });
    </script>
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
                        $.each(data.dataBarang, function(index, val) {
                            console.log(val.id);
                            if (val.jenis_barang_id == jenis_barang_id) {
                                console.log('<option value="' + val.id + '"> ' + val
                                    .nama_barang + ' </option>');
                                $('#barang_id').append('<option value="' + val.id +
                                    '"> ' + val.nama_barang + ' (Stok: ' + val
                                    .tersedia + ')</option>');
                            }
                        });
                    }

                });
            });
        });
    </script>
@endpush
@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
