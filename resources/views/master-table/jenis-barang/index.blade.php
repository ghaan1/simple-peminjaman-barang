@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manajemen Master</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Manajemen Jenis barang</h2>
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Jenis Barang</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary"
                                    href="{{ route('jenis-barang.create') }}">Tambah Data
                                    Jenis barang</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Cari Jenis barang</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('jenis-barang.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-10">
                                            <label for="role">Jenis Barang</label>
                                            <input type="text" name="jenis_barang" class="form-control" id="jenis_barang"
                                                placeholder="Jenis Barang" value="{{ $jenis_barang }}">
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('jenis-barang.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode</th>
                                            <th>Jenis Barang</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($jenisBarangs as $key => $jenisBarang)
                                            <tr>
                                                <td>{{ ($jenisBarangs->currentPage() - 1) * $jenisBarangs->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $jenisBarang->kode_jb }}</td>
                                                <td>{{ $jenisBarang->jenis_barang }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('jenis-barang.edit', $jenisBarang->id) }}"
                                                            class="btn btn-sm btn-info btn-icon "><i
                                                                class="fas fa-edit"></i>
                                                            Ubah</a>
                                                        <form action="{{ route('jenis-barang.destroy', $jenisBarang->id) }}"
                                                            method="POST" class="ml-2" id="del-<?= $jenisBarang->id ?>">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button type="submit" id="#submit"
                                                                class="btn btn-sm btn-danger btn-icon "
                                                                data-confirm="Hapus Jenis Barang ?|Apakah Kamu Yakin?"
                                                                data-confirm-yes="submitDel(<?= $jenisBarang->id ?>)"
                                                                data-id="del-{{ $jenisBarang->id }}">
                                                                <i class="fas fa-times"> </i> Hapus </button>
                                                        </form>

                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $jenisBarangs->withQueryString()->links() }}
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
@endpush
