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
                <li class="breadcrumb-item"><a href="#">Kategori</a></li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Data Kategori (Query Builder)</h1>
                <p class="mb-0">Dikelola menggunakan Laravel Query Builder dengan relasi <code>leftJoin</code> & pencarian.</p>
            </div>
            <div>
                <a href="{{ route('category.create') }}" class="btn btn-success text-white">
                    <svg class="icon icon-xs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Kategori
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <!-- Pencarian (Eksplorasi Query Builder Where) -->
                    <form action="{{ route('category.index') }}" method="GET" class="row mb-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama atau deskripsi..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">Cari</button>
                                @if (request('search'))
                                    <a href="{{ route('category.index') }}" class="btn btn-outline-secondary">Reset</a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">#</th>
                                    <th class="border-0">Nama Kategori</th>
                                    <th class="border-0">Slug</th>
                                    <th class="border-0">Deskripsi</th>
                                    <th class="border-0">Jumlah Post (LeftJoin)</th>
                                    <th class="border-0 rounded-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataCategories as $index => $item)
                                    <tr>
                                        <td>{{ $dataCategories->firstItem() + $index }}</td>
                                        <td class="fw-bold">{{ $item->name }}</td>
                                        <td><span class="badge bg-secondary">{{ $item->slug }}</span></td>
                                        <td>{{ $item->description ?: '-' }}</td>
                                        <td>
                                            <span class="badge bg-info text-dark">
                                                {{ $item->total_posts }} Post
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('category.edit', $item->id) }}" class="btn btn-info btn-sm text-white">
                                                Edit
                                            </a>
                                            <form action="{{ route('category.destroy', $item->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini? Semua post di kategori ini juga akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $dataCategories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
