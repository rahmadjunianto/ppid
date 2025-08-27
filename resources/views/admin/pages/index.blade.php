@extends('admin.layouts.app')

@section('title', 'Kelola Halaman')
@section('page-title', 'Kelola Halaman')

@section('breadcrumb')
    <li class="breadcrumb-item active">Kelola Halaman</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt mr-2"></i>
                        Daftar Halaman
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Halaman
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('admin.pages.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text"
                                               name="search"
                                               class="form-control"
                                               placeholder="Cari halaman..."
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status" class="form-control">
                                            <option value="">Semua Status</option>
                                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="template" class="form-control">
                                            <option value="">Semua Template</option>
                                            @foreach($templateOptions as $key => $label)
                                                <option value="{{ $key }}" {{ request('template') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="parent" class="form-control">
                                            <option value="">Semua Parent</option>
                                            <option value="root" {{ request('parent') == 'root' ? 'selected' : '' }}>Root Pages</option>
                                            @foreach($parentPages as $id => $title)
                                                <option value="{{ $id }}" {{ request('parent') == $id ? 'selected' : '' }}>
                                                    {{ $title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Results Count -->
                    <p class="text-muted">
                        Menampilkan {{ $pages->firstItem() ?? 0 }} - {{ $pages->lastItem() ?? 0 }}
                        dari {{ $pages->total() }} halaman
                    </p>

                    <!-- Table -->
                    @if($pages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="60">No</th>
                                        <th>Judul</th>
                                        <th>URL</th>
                                        <th width="100">Template</th>
                                        <th width="80">Status</th>
                                        <th width="80">Menu</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pages as $index => $page)
                                        <tr>
                                            <td>{{ $pages->firstItem() + $index }}</td>
                                            <td>
                                                @if($page->parent_id)
                                                    <span class="text-muted">└─</span>
                                                @endif
                                                <strong>{{ $page->title }}</strong>
                                                @if($page->is_homepage)
                                                    <span class="badge badge-warning ml-1">Homepage</span>
                                                @endif
                                                <br>
                                                <small class="text-muted">
                                                    {{ Str::limit($page->excerpt, 60) }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ $page->url }}" target="_blank" class="text-info">
                                                    <small>{{ Str::limit($page->url, 40) }}</small>
                                                    <i class="fas fa-external-link-alt ml-1"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <small class="badge badge-info">{{ $page->template }}</small>
                                            </td>
                                            <td class="text-center">
                                                {!! $page->status_badge !!}
                                            </td>
                                            <td class="text-center">
                                                @if($page->show_in_menu)
                                                    <span class="badge badge-success">Ya</span>
                                                @else
                                                    <span class="badge badge-secondary">Tidak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.pages.show', $page) }}" 
                                                       class="btn btn-info btn-sm" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.pages.edit', $page) }}" 
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.pages.duplicate', $page) }}"
                                                          method="POST"
                                                          style="display: inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary btn-sm" title="Duplikasi">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.pages.destroy', $page) }}"
                                                          method="POST"
                                                          style="display: inline-block;"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($pages->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <small class="text-muted">
                                        Menampilkan {{ $pages->firstItem() }} - {{ $pages->lastItem() }}
                                        dari {{ $pages->total() }} halaman
                                    </small>
                                </div>
                                <div>
                                    {{ $pages->appends(request()->query())->links('admin-pagination') }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data halaman</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
