@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manajemen Peran dan Perizinan</h1>

        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah Perizinan</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Form Ubah Perizinan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Perizinan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $permission->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Guard Name</label>
                            <input type="text" class="form-control @error('guard_name') is-invalid @enderror"
                                id="guard_name" name="guard_name" value="{{ old('guard_name', $permission->guard_name) }}">
                            @error('guard_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('permission.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
