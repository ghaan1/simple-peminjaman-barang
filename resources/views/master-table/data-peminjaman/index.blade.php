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
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Data Peminjaman</a>
                                @role('admin-rt')
                                    <a class="btn btn-icon icon-left btn-primary" href="{{ route('data-peminjaman.print') }}"
                                        target="_blank">Print Data Peminjaman</a>
                                @endrole
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('data-peminjaman.index') }}">
                                    <div class="form-col"
                                        style="display: flex; flex-direction: row; align-items: center; padding-left:100px;">
                                        <div class="form-row">
                                            <div class="form-dol" style="width: 500px">
                                                <div class="form-group col-md-8">
                                                    <label for="role">Nama Peminjam</label>
                                                    <select class="form-control select2" name="users[]" multiple
                                                        data-id="select-user" id="users">
                                                        <option value="">Pilih Nama Peminjam </option>
                                                        @foreach ($users as $listUser)
                                                            <option value="{{ $listUser->id }}"
                                                                {{ (is_array(old('users')) && in_array($listUser->id, old('users'))) ||
                                                                (isset($userSelected) && in_array($listUser->id, $userSelected))
                                                                    ? 'selected'
                                                                    : '' }}>
                                                                {{ $listUser->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-dol" style="width: 685px;">
                                                <div class="form-group col-md-8">
                                                    <label for="role">Jenis Barang</label>
                                                    <select class="form-control select2" name="jenisbarang[]" multiple
                                                        data-id="select-user" id="jenisbarang">
                                                        <option value="">Pilih Jenis Barang </option>
                                                        @foreach ($jenisBarang as $listJenisBarang)
                                                            <option value="{{ $listJenisBarang->id }}"
                                                                {{ (is_array(old('jenisBarang')) && in_array($listJenisBarang->id, old('jenisBarang'))) || (isset($jenisBarangSelected) && in_array($listJenisBarang->id, $jenisBarangSelected)) ? 'selected' : '' }}>
                                                                {{ $listJenisBarang->jenis_barang }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-9" style=" margin-left: 10px">
                                                <label for="status">Status</label>
                                                <select class="form-control select2" name="status[]" multiple
                                                    data-id="select-status" id="status">
                                                    <option value="">Pilih Status</option>
                                                    @foreach ($status as $value)
                                                        <option value="{{ $value }}"
                                                            {{ (is_array(old('status')) && in_array($value, old('status'))) || (isset($statusSelected) && in_array($value, $statusSelected)) ? 'selected' : '' }}>
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-9" style=" margin-left: 10px">
                                                <label for="role">Nama Barang</label>
                                                <input type="text" name="nama_barang" class="form-control"
                                                    id="nama_barang" placeholder="Nama Barang" data-id="search-perusahaan"
                                                    value="{{ $nama_barang }}">
                                            </div>
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
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Quantity</th>
                                            <th>Tanggal Pinjam</th>
                                            @role('admin-rt')
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
                                                <td>{{ $itemPeminjaman->kode_jbs }}</td>
                                                <td>{{ $itemPeminjaman->nama_barang }}</td>
                                                <td>{{ $itemPeminjaman->quantity }}</td>
                                                <td>{{ $itemPeminjaman->tanggal_pinjam }}</td>
                                                @role('admin-rt')
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
                                                                    @if (session()->has('error'))
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-primary btn-icon" disabled>
                                                                            <i class="fas fa-check"></i> Barang Sudah Kembali
                                                                        </button>
                                                                    @else
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-primary btn-icon">
                                                                            <i class="fas fa-check"></i> Barang Sudah Kembali
                                                                        </button>
                                                                    @endif
                                                                </form>
                                                            @elseif ($itemPeminjaman->status == 'Sudah Dikembalikan')
                                                                <form
                                                                    action="{{ route('data-peminjaman.update-status', $itemPeminjaman->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status"
                                                                        value="Sedang Dipinjam">
                                                                    @if (session()->has('error'))
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-danger btn-icon" disabled>
                                                                            <i class="fas fa-check"></i> Batalkan Barang Sudah
                                                                            Kembali
                                                                        </button>
                                                                    @else
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger btn-icon">
                                                                            <i class="fas fa-check"></i> Batalkan Barang Sudah
                                                                            Kembali
                                                                        </button>
                                                                    @endif
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
                                                        <button class="btn btn-sm btn-primary btn-icon show-foto-btn"
                                                            data-toggle="modal"
                                                            data-target="#modal-foto-{{ $itemPeminjaman->id }}"
                                                            data-id="{{ $itemPeminjaman->id }}"
                                                            data-val="{{ $itemPeminjaman->ktp_peminjam }}">
                                                            <i class="fas fa-image"></i> Tampilkan Foto
                                                        </button>
                                                        <a href="{{ route('data-peminjaman.edit', $itemPeminjaman->id) }}"
                                                            class="btn btn-sm btn-info btn-icon ml-2"><i
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
    <script>
        $(document).ready(function() {
            $('.show-foto-btn').click(function() {
                var id = $(this).data('id');
                var fotoUrl = $(this).data('val');
                var modalHtml = `
            <div class="modal fade" tabindex="-1" role="dialog" id="modal-foto-${id}">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-foto-${id}-label">Foto Peminjaman</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset('storage/${fotoUrl}') }}" alt="Foto Peminjaman" style="max-width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        `;
                $('body').append(modalHtml);
                $(`#modal-foto-${id}`).modal('show');
            });
        });
    </script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
