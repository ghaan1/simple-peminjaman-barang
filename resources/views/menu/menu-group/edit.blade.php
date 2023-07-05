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
                    <form action="{{ route('menu-group.update', $menuGroup->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $menuGroup->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
