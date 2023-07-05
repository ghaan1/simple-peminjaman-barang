@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Menu Group dan Menu Item</h1>
         
        </div>
        <div class="section-body">
            <h2 class="section-title">Kelola Menu Group</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Tambah Menu Group</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('menu-group.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Menu Group Name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Ikon</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon"
                                name="icon" placeholder="Font Aweseome Icon Name" value="{{ old('icon') }}">
                            @error('icon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Permission Name</label>
                            <select class="form-control select2" name="permission_name">
                                <option value="">Choose Role</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            @error('permission_name')
                                {{ $message }}
                            @enderror
                        </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('menu-group.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
