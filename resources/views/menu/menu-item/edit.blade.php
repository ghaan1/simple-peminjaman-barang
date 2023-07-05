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
                    <h4>Ubah Menu Group</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('menu-item.update', $menuItem->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Parent</label>
                            <select class="form-control select2" name="menu_group_id">
                                <option value="">Pilih Menu Group</option>
                                @foreach ($menuGroups as $item)
                                    <option @selected($item->id == $menuItem->menu_group_id) value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('menu_group_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Menu Item</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Menu Item Name" value="{{ old('name', $menuItem->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Permission</label>
                            <input type="text" class="form-control @error('permission_name') is-invalid @enderror"
                                id="permission_name" name="permission_name" placeholder="Permission Name"
                                value="{{ old('permission_name', $menuItem->permission_name) }}">
                            @error('permission_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Url</label>
                            <select class="form-control select2" name="route">
                                <option value="">Pilih Url</option>
                                @foreach ($routeCollection as $item)
                                    <option @selected($item->uri() == $menuItem->route) value="{{ $item->uri() }}">{{ $item->uri() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('menu-item.index') }}">Batal</a>
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
