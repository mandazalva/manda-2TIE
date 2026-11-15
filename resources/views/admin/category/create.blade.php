@extends('layouts.admin.app')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Tambah Kategori (Query Builder)</h1>
                <p class="mb-0">Form untuk menambahkan data kategori baru menggunakan Query Builder.</p>
            </div>
            <div>
                <a href="{{ route('category.index') }}" class="btn btn-outline-gray-600">Kembali</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" placeholder="Contoh: Web Development" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Deskripsi</label>
                            <textarea id="description" class="form-control" name="description" rows="3" placeholder="Deskripsi singkat kategori (opsional)">{{ old('description') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-gray-800">Simpan Kategori</button>
                            <a href="{{ route('category.index') }}" class="btn btn-link text-gray-600">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
