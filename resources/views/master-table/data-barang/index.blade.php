@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Master Table Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Data barang Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Data Barang</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary"
                                    href="{{ route('data-barang.create') }}">Create New
                                    Data barang</a>
                                <a class="btn btn-info btn-primary active" href="#">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Export Data barang</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Data barang</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('data-barang.index') }}">
                                    <div class="form-col" style="display: flex; flex-direction: center">
                                    <div class="form-row">
                                        <div class="form-group col-md-10">
                                            <label for="role">Nama Barang</label>
                                            <input type="text" name="nama_barang" class="form-control" id="nama_barang"
                                                placeholder="Nama Barang">
                                        </div>
                                    </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-10">
                                                <label for="role">Jenis Barang</label>
                                                <input type="text" name="jenis_barang" class="form-control" id="jenis_barang"
                                                placeholder="Jenis Barang">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('data-barang.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Input</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis Barang</th>
                                            <th>Harga Barang</th>
                                            <th>Quantity</th>
                                            <th>Tersediaan</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($dataBarangs as $key => $dataBarang)
                                        <tr>
                                            <td>{{ ($dataBarangs->currentPage() - 1) * $dataBarangs->perPage() + $key + 1 }}
                                            </td>
                                            <td>{{$dataBarang->admin_id}}</td>
                                            <td>{{$dataBarang->nama_barang}}</td>
                                            <td>{{$dataBarang->jenis_barang}}</td>
                                            <td>{{$dataBarang->harga_barang}}</td>
                                            <td>{{$dataBarang->quantity}}</td>
                                            <td>{{$dataBarang->tersedia}}</td>
                                            <td class="text-right">
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ route('data-barang.edit', $dataBarang->id) }}" class="btn btn-sm btn-info btn-icon "><i
                                                            class="fas fa-edit"></i>
                                                        Edit</a>
                                                        <form
                                                        action="{{ route('data-barang.destroy', $dataBarang->id) }}"
                                                        method="POST" class="ml-2"
                                                        id="del-<?= $dataBarang->id ?>">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" id="#submit"
                                                            class="btn btn-sm btn-danger btn-icon "
                                                            data-confirm="Hapus Data Barang?|Apakah Kamu Yakin?"
                                                            data-confirm-yes="submitDel(<?= $dataBarang->id ?>)" data-id="#">
                                                            <i class="fas fa-times"> </i> Delete </button>
                                                    </form>

                                                </div>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $dataBarangs->withQueryString()->links() }}

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
