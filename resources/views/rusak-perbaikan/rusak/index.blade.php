@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tabel Data Rusak - Perbaikan</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tabel Data Barang Rusak</h2>
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Barang Rusak</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('rusak.create') }}">Tambah Data
                                    Barang Rusak</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Cari Data Barang Rusak</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('rusak.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-10">
                                            <label for="role">Nama Barang</label>
                                            <input type="text" name="jenis_barang" class="form-control" id="jenis_barang"
                                                placeholder="Nama Barang">
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('rusak.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Barang</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($dataRusak as $key => $listBarangRusak)
                                            <tr>
                                                <td>{{ ($dataRusak->currentPage() - 1) * $dataRusak->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $listBarangRusak->nama_barang }}</td>
                                                <td>{{ $listBarangRusak->quantity_rusak }}</td>
                                                <td>{{ $listBarangRusak->status_rusak }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <form action="{{ route('rusak.destroy', $listBarangRusak->id) }}"
                                                            method="POST" class="ml-2"
                                                            id="del-<?= $listBarangRusak->id ?>">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button type="submit" id="#submit"
                                                                class="btn btn-sm btn-danger btn-icon "
                                                                data-confirm="Hapus Data Rusak ?|Apakah Kamu Yakin?"
                                                                data-confirm-yes="submitDel(<?= $listBarangRusak->id ?>)"
                                                                data-id="del-{{ $listBarangRusak->id }}">
                                                                <i class="fas fa-times"> </i> Delete </button>
                                                        </form>

                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $dataRusak->withQueryString()->links() }}
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
