@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Peran dan Perizinan</h1>

        </div>
        <div class="section-body">
            <h2 class="section-title">Ubah Peran</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Form Ubah Peran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama Peran</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $role->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Guard Name</label>
                            <input type="text" class="form-control @error('guard_name') is-invalid @enderror"
                                id="guard_name" name="guard_name" value="{{ old('guard_name', $role->guard_name) }}">
                            @error('guard_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('role.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
