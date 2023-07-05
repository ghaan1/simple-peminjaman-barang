@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Peran dan Perizinan</h1>

        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Peran</h2>
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Peran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('role.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Peran</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Nama Peran" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Pengaman</label>
                            <input type="text" class="form-control @error('guard_name') is-invalid @enderror"
                                id="guard_name" name="guard_name" placeholder="Web" value="{{ old('guard_name', 'web') }}">
                            @error('guard_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Kirim</button>
                    <a class="btn btn-secondary" href="{{ route('role.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
