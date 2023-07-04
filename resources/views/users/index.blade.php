@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>User List</h1>

        </div>
        <div class="section-body">
            <h2 class="section-title">User Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>User List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('user.create') }}">Tambah Baru
                                    User</a>
                                <a class="btn btn-info btn-primary active" href="{{ route('user.export') }}">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Export User</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Cari User</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="show-import" style="display: none">
                                <div class="custom-file">
                                    <form action="{{ route('user.import') }}" method="post" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <label class="custom-file-label" for="file-upload">Pilih File</label>
                                        <input type="file" id="file-upload" class="custom-file-input" name="import_file">
                                        <br /> <br />
                                        <div class="footer text-right">
                                            <button class="btn btn-primary">Import File</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('user.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="role">User</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="User Name">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('user.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <tbody>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Verified At</th>
                                            <th>Created At</th>
                                            <th class="text-right">Action</th>
                                            <th class="text-right">Verified User</th>
                                        </tr>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $key + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if ($user->email_verified_at)
                                                        {{ $user->email_verified_at }}
                                                    @else
                                                        Access Denied
                                                    @endif
                                                </td>
                                                <td>{{ $user->created_at }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('user.edit', $user->id) }}"
                                                            class="btn btn-sm btn-info btn-icon "><i
                                                                class="fas fa-edit"></i>
                                                            Ubah</a>
                                                        <form action="{{ route('user.destroy', $user->id) }}"
                                                            method="POST" class="ml-2" id="del-<?= $user->id ?>">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button type="submit" id="#submit"
                                                                class="btn btn-sm btn-danger btn-icon "
                                                                data-confirm="Hapus User List?|Apakah Kamu Yakin?"
                                                                data-confirm-yes="submitDel(<?= $user->id ?>)"
                                                                data-id="del-{{ $user->id }}">
                                                                <i class="fas fa-times"> </i> Hapus </button>
                                                        </form>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end">
                                                        @if (is_null($user->email_verified_at))
                                                            <form
                                                                action="{{ route('user.verify-email', ['id' => $user->id, 'hash' => sha1($user->email)]) }}"
                                                                method="POST" class="d-inline-block"
                                                                id="vel-<?= $user->id ?>">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-primary ml-2"
                                                                    data-confirm="Verifikasi Data User |Apakah Kamu Yakin Verifikasi ?"
                                                                    data-confirm-yes="submitVeri(<?= $user->id ?>)"
                                                                    data-id="vel-{{ $user->id }}">Verify Email</button>
                                                            </form>
                                                        @else
                                                            <form
                                                                action="{{ route('user.verify-email', ['id' => $user->id, 'hash' => sha1($user->email)]) }}"
                                                                method="POST" class="d-inline-block"
                                                                id="vel-<?= $user->id ?>">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger ml-2"
                                                                    data-confirm="Verifikasi Data User |Apakah Kamu Yakin Batalkan Verifikasi ?"
                                                                    data-confirm-yes="submitVeri(<?= $user->id ?>)"
                                                                    data-id="vel-{{ $user->id }}">Hapus Verify
                                                                    Email</button>
                                                            </form>
                                                        @endif
                                                        <button class="btn btn-sm btn-info btn-icon toggle-details ml-2"
                                                            data-target="#details-{{ $user->profile_id }}">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr id="details-{{ $user->profile_id }}" style="display: none;">
                                                <td colspan="10">

                                                    <h6>Data Perusahaan</h6>
                                                    <table class="table table-bordered table-md">
                                                        <tr>
                                                            <th>NIK</th>
                                                            <th>Tanggal Lahir</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th>Alamat</th>
                                                            <th>Nomer HP</th>
                                                            <th>KTP</th>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $user->nik }}</td>
                                                            <td>{{ $user->tanggal_lahir }}</td>
                                                            <td>{{ $user->jenis_kelamin }}</td>
                                                            <td>{{ $user->alamat }}</td>
                                                            <td>{{ $user->no_hp }}</td>
                                                            <td><img src="{{ Storage::url($user->ktp) }}" width="100">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br />

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $users->withQueryString()->links() }}
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
    <script>
        $(document).ready(function() {
            var detailStatus = {};
            $('.toggle-details').click(function() {
                var targetId = $(this).data('target');
                var kbliperusahaanId = targetId.split('-')[1];

                for (var id in detailStatus) {
                    if (id != kbliperusahaanId && detailStatus[id] === true) {
                        $('#details-' + id).toggle();
                        $('.toggle-details[data-target="#details-' + id + '"] i')
                            .toggleClass('fa-chevron-down fa-chevron-up');
                        detailStatus[id] = false;
                    }
                }

                $(targetId).toggle();
                $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
                detailStatus[kbliperusahaanId] = $(targetId).is(':visible');
            });
        });
    </script>
@endpush

@push('customStyle')
@endpush
