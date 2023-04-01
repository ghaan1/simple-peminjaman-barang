@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Master Table Management</h1>
            
        </div>

        <div class="section-body">
            <h2 class="section-title">Data Peminjaman Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Data Peminjaman</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary"
                                    href="{{ route('data-peminjaman.create') }}">Create New
                                    Data Peminjaman</a>
                                <a class="btn btn-info btn-primary active" href="#">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Export Data Peminjaman</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Data Peminjaman</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('data-peminjaman.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="role">Data Peminjaman</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="User Name">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('data-peminjaman.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Peminjam</th>
                                            <th>Jenis Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Quantity</th>
                                            <th>Tanggal Pinjam</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn btn-sm btn-info btn-icon "><i
                                                            class="fas fa-edit"></i>
                                                        Edit</a>
                                                    <form action="#" method="POST" class="ml-2" id="#">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" id="#submit"
                                                            class="btn btn-sm btn-danger btn-icon "
                                                            data-confirm="Hapus User List?|Apakah Kamu Yakin?"
                                                            data-confirm-yes="#" data-id="#">
                                                            <i class="fas fa-times"> </i> Delete </button>
                                                    </form>

                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">

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
