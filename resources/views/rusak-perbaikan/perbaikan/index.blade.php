@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Data Rusak - Perbaikan</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tabel Data Barang Perbaikan</h2>
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Barang Perbaikan</h4>
                            <div class="card-header-action">
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Cari Data Barang Perbaikan</a>
                                @role('admin-rt')
                                    <a class="btn btn-icon icon-left btn-primary" href="{{ route('perbaikan.print') }}"
                                        target="_blank">Print Data Peminjaman</a>
                                @endrole
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('perbaikan.index') }}">
                                    <div class="form-group col-md-9" style=" margin-left: 10px">
                                        <label for="role">Nama Barang</label>
                                        <input type="text" name="nama_barang" class="form-control" id="nama_barang"
                                            placeholder="Nama Barang" data-id="search-perusahaan"
                                            value="{{ $nama_barang }}">
                                    </div>
                                    <div id="tanggalGroup" class="form-group col-md-4" style="margin-left: 10px;">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" id="tanggal"
                                            placeholder="Tanggal" value="{{ $tanggalSelected }}">
                                    </div>

                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('perbaikan.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal Perbaikan</th>
                                            <th>Nama User</th>
                                            <th>Nama Barang</th>
                                            <th>Status</th>
                                            <th>Quantity</th>
                                            <th>Bukti Perbaikan</th>
                                            <th>KTP</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($dataPerbaikan as $key => $listBarangPerbaikan)
                                            <tr>
                                                <td>{{ ($dataPerbaikan->currentPage() - 1) * $dataPerbaikan->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $listBarangPerbaikan->tanggal_perbaikan }}</td>
                                                <td>{{ $listBarangPerbaikan->name }}</td>
                                                <td>{{ $listBarangPerbaikan->nama_barang }}</td>
                                                <td>{{ $listBarangPerbaikan->status_rusak }}</td>
                                                <td>{{ $listBarangPerbaikan->quantity_rusak }}</td>
                                                <td>{{ $listBarangPerbaikan->bukti_perbaikan }}</td>
                                                <td>{{ $listBarangPerbaikan->ktp_perbaikan }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('perbaikan.edit', $listBarangPerbaikan->id) }}"
                                                            class="btn btn-sm btn-info btn-icon "><i
                                                                class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <form
                                                            action="{{ route('rusak.destroy', $listBarangPerbaikan->id) }}"
                                                            method="POST" class="ml-2"
                                                            id="del-<?= $listBarangPerbaikan->id ?>">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button type="submit" id="#submit"
                                                                class="btn btn-sm btn-danger btn-icon "
                                                                data-confirm="Hapus Data Rusak ?|Apakah Kamu Yakin?"
                                                                data-confirm-yes="submitDel(<?= $listBarangPerbaikan->id ?>)"
                                                                data-id="del-{{ $listBarangPerbaikan->id }}">
                                                                <i class="fas fa-times"> </i> Delete </button>
                                                        </form>

                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $dataPerbaikan->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.import').click(function(event) {
                event.stopPropagation();
                $(".show-import").slideToggle("fast");
                $(".show-search").hide();
            });
            $('.search').click(function(event) {
                event.stopPropagation();
                $(".show-search").slideToggle("fast");
                $(".show-import").hide();
            });
            //ganti label berdasarkan nama file
            $('#file-upload').change(function() {
                var i = $(this).prev('label').clone();
                var file = $('#file-upload')[0].files[0].name;
                $(this).prev('label').text(file);
            });

        });

        function submitDel(id) {
            $('#del-' + id).submit()
        }

        function submitVeri(id) {
            $('#vel-' + id).submit()
        }
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
