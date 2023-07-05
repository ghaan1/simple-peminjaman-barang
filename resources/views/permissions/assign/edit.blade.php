@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Peran dan Perizinan</h1>
          
        </div>
        <div class="section-body">
            <h2 class="section-title">Kelola Peran dan Perizinan</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Peran dan Perizinan</h4>
                </div>
                <form action="{{ route('assign.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Peran</label>
                            <select name="role" class="form-control select2">
                                <option value="">Pilih Peran</option>
                                @foreach ($roles as $item)
                                    <option {{ $role->id === $item->id ? 'selected' : '' }} value="{{ $item->id }}">
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Perizinan</label>
                            <select name="permissions[]" class="form-control select2" multiple>
                                @foreach ($permissions as $permission)
                                    <option {{ $role->permissions()->find($permission->id) ? 'selected' : '' }}
                                        value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                            @error('permissions')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Kirim</button>
                        <a class="btn btn-secondary" href="{{ route('assign.index') }}">Batal</a>
                    </div>
                </form>
            </div>
    </section>
@endsection

@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
