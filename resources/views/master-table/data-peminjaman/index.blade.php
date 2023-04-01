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
                                            @role('super-admin')
                                                <th>Status</th>
                                                <th class="text-right">Action Status</th>
                                            @endrole
                                            @role('user')
                                                <th>Status</th>
                                            @endrole
                                            <th class="text-right">Action</th>
                                        </tr>
                                        @foreach ($dataPeminjaman as $key => $itemPeminjaman)
                                            <tr>
                                                <td>{{ ($dataPeminjaman->currentPage() - 1) * $dataPeminjaman->perPage() + $key + 1 }}
                                                <td>{{ $itemPeminjaman->name }}</td>
                                                <td>{{ $itemPeminjaman->jenis_barang }}</td>
                                                <td>{{ $itemPeminjaman->nama_barang }}</td>
                                                <td>{{ $itemPeminjaman->quantity }}</td>
                                                <td>{{ $itemPeminjaman->tanggal_pinjam }}</td>
                                                @role('super-admin')
                                                    <td>{{ $itemPeminjaman->status }}</td>
                                                    <td class="text-right">
                                                        <div class="d-flex justify-content-end">
                                                            @if ($itemPeminjaman->status == 'Sedang Dipinjam')
                                                                <form
                                                                    action="{{ route('data-peminjaman.update-status', $itemPeminjaman->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status"
                                                                        value="Sudah Dikembalikan">
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-primary btn-icon">
                                                                        <i class="fas fa-check"></i> Barang Sudah Kembali
                                                                    </button>
                                                                </form>
                                                            @elseif ($itemPeminjaman->status == 'Sudah Dikembalikan')
                                                                <form
                                                                    action="{{ route('data-peminjaman.update-status', $itemPeminjaman->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status"
                                                                        value="Sedang Dipinjam">
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger btn-icon">
                                                                        <i class="fas fa-check"></i> Batalkan Barang Sudah
                                                                        Kembali
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endrole
                                                @role('user')
                                                    @if ($itemPeminjaman->status == 'Sedang Dipinjam')
                                                        <td>Barang Sedang Dipinjam</td>
                                                    @elseif ($itemPeminjaman->status == 'Sudah Dikembalikan')
                                                        <td>Barang Telah Dikembalikan</td>
                                                    @endif
                                                @endrole
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('data-peminjaman.edit', $itemPeminjaman->id) }}"
                                                            class="btn btn-sm btn-info btn-icon "><i
                                                                class="fas fa-edit"></i>
                                                            Edit</a>
                                                        <form
                                                            action="{{ route('data-peminjaman.destroy', $itemPeminjaman->id) }}"
                                                            method="POST" class="ml-2"
                                                            id="del-<?= $itemPeminjaman->id ?>">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button type="submit" id="#submit"
                                                                class="btn btn-sm btn-danger btn-icon "
                                                                data-confirm="Hapus Data Peminjaman?|Apakah Kamu Yakin?"
                                                                data-confirm-yes="submitDel(<?= $itemPeminjaman->id ?>)"
                                                                data-id="#">
                                                                <i class="fas fa-times"> </i> Delete </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $dataPeminjaman->withQueryString()->links() }}
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
