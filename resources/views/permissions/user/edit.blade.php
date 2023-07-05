@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Peran dan Perizinan</h1>
        
        </div>
        <div class="section-body">
            <h2 class="section-title">Sync User ke Peran</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Sync User ke Peran Form</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('assign.user.update', $user) }}" method="post">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <label>User</label>
                            <select name="user" class="form-control select2">
                                <option value="{{ $user->id }}" selected> {{ $user->name }}</option>
                            </select>
                            @error('user')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Roles</label>
                            <select name="roles[]" class="form-control select2" multiple>
                                @foreach ($roles as $role)
                                    <option {{ $user->roles()->find($role->id) ? 'selected' : '' }}
                                        value="{{ $role->id }}">{{ $role->name }}</option>
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
