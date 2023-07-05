@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Peran dan Perizinan</h1>
        
        </div>
        <div class="section-body">
            <h2 class="section-title">Izin User ke Peran</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Izin User ke Peran Form</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('assign.user.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>User</label>
                            <select name="user" class="form-control select2">
                                <option value="">Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Roles</label>
                            <select name="roles[]" class="form-control select2" multiple>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                {{ $message }}
                            @enderror
                        </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('assign.user.index') }}">Batal</a>
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
