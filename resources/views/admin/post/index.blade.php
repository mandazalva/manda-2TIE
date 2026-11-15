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
                <li class="breadcrumb-item"><a href="#">Posts</a></li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Data Posts (Eloquent ORM)</h1>
                <p class="mb-0">Dikelola menggunakan Laravel Eloquent ORM dengan relasi <code>belongsTo(Category)</code>.</p>
            </div>
            <div>
                <a href="{{ route('post.create') }}" class="btn btn-success text-white">
                    <svg class="icon icon-xs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Post
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
                    <!-- Filter Kategori & Pencarian -->
                    <form action="{{ route('post.index') }}" method="GET" class="row g-2 mb-3">
                        <div class="col-md-3">
                            <select name="category_id" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Semua Kategori --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari judul/isi post..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">Cari</button>
                                @if (request('search') || request('category_id'))
                                    <a href="{{ route('post.index') }}" class="btn btn-outline-secondary">Reset</a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">#</th>
                                    <th class="border-0">Judul Post</th>
                                    <th class="border-0">Kategori (Relasi)</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Tanggal Dibuat</th>
                                    <th class="border-0 rounded-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataPosts as $index => $item)
                                    <tr>
                                        <td>{{ $dataPosts->firstItem() + $index }}</td>
                                        <td>
                                            <span class="fw-bold">{{ $item->title }}</span>
                                            <br>
                                            <small class="text-muted">{{ Str::limit(strip_tags($item->content), 50) }}</small>
                                        </td>
                                        <td>
                                            @if ($item->category)
                                                <span class="badge bg-primary">{{ $item->category->name }}</span>
                                            @else
                                                <span class="badge bg-danger">Tanpa Kategori</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->is_published)
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <a href="{{ route('post.edit', $item->id) }}" class="btn btn-info btn-sm text-white">
                                                Edit
                                            </a>
                                            <form action="{{ route('post.destroy', $item->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data postingan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $dataPosts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
