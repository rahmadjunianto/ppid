@extends('admin.layouts.app')

@section('title', 'Detail Halaman')
@section('page-title', 'Detail Halaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">Kelola Halaman</a></li>
    <li class="breadcrumb-item active">Detail Halaman</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye mr-2"></i>
                        {{ $page->title }}
                    </h3>
                    <div class="card-tools">
                        @if($page->getUrl())
                            <a href="{{ $page->getUrl() }}" target="_blank" class="btn btn-success btn-sm">
                                <i class="fas fa-external-link-alt"></i> Lihat di Website
                            </a>
                        @endif
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Informasi Halaman</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th width="200">Judul</th>
                                            <td>{{ $page->title }}</td>
                                        </tr>
                                        <tr>
                                            <th>Slug</th>
                                            <td>
                                                <code>{{ $page->slug }}</code>
                                                @if($page->getUrl())
                                                    <br><small class="text-muted">URL: {{ $page->getUrl() }}</small>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @switch($page->status)
                                                    @case('published')
                                                        <span class="badge badge-success">Published</span>
                                                        @break
                                                    @case('draft')
                                                        <span class="badge badge-warning">Draft</span>
                                                        @break
                                                    @case('archived')
                                                        <span class="badge badge-secondary">Archived</span>
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Template</th>
                                            <td>{{ ucfirst($page->template) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Parent Page</th>
                                            <td>
                                                @if($page->parent)
                                                    <a href="{{ route('admin.pages.show', $page->parent) }}">
                                                        {{ $page->parent->title }}
                                                    </a>
                                                @else
                                                    <em>Root Page</em>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Urutan</th>
                                            <td>{{ $page->sort_order }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tampil di Menu</th>
                                            <td>
                                                @if($page->show_in_menu)
                                                    <span class="badge badge-success">Ya</span>
                                                @else
                                                    <span class="badge badge-secondary">Tidak</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Homepage</th>
                                            <td>
                                                @if($page->is_homepage)
                                                    <span class="badge badge-primary">Ya</span>
                                                @else
                                                    <span class="badge badge-secondary">Tidak</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Publikasi</th>
                                            <td>
                                                @if($page->published_at)
                                                    {{ $page->published_at->format('d M Y H:i') }}
                                                @else
                                                    <em>Belum ditentukan</em>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Dibuat</th>
                                            <td>{{ $page->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Diupdate</th>
                                            <td>{{ $page->updated_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Excerpt -->
                            @if($page->excerpt)
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Ringkasan</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $page->excerpt }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Content -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Konten</h5>
                                </div>
                                <div class="card-body">
                                    @if($page->content)
                                        <div class="content-preview">
                                            {!! $page->content !!}
                                        </div>
                                    @else
                                        <em class="text-muted">Tidak ada konten</em>
                                    @endif
                                </div>
                            </div>

                            <!-- SEO Information -->
                            @if($page->meta_title || $page->meta_description || $page->meta_keywords)
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">SEO Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        @if($page->meta_title)
                                        <tr>
                                            <th width="200">Meta Title</th>
                                            <td>{{ $page->meta_title }}</td>
                                        </tr>
                                        @endif
                                        @if($page->meta_description)
                                        <tr>
                                            <th>Meta Description</th>
                                            <td>{{ $page->meta_description }}</td>
                                        </tr>
                                        @endif
                                        @if($page->meta_keywords)
                                        <tr>
                                            <th>Meta Keywords</th>
                                            <td>{{ $page->meta_keywords }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Featured Image -->
                            @if($page->featured_image)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Featured Image</h5>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ asset('storage/' . $page->featured_image) }}"
                                         alt="{{ $page->title }}" class="img-fluid rounded">
                                </div>
                            </div>
                            @endif

                            <!-- Child Pages -->
                            @if($page->children->count() > 0)
                            <div class="card {{ $page->featured_image ? 'mt-3' : '' }}">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Sub Halaman</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        @foreach($page->children as $child)
                                            <li class="mb-2">
                                                <a href="{{ route('admin.pages.show', $child) }}">
                                                    {{ $child->title }}
                                                </a>
                                                @switch($child->status)
                                                    @case('published')
                                                        <span class="badge badge-success badge-sm">Published</span>
                                                        @break
                                                    @case('draft')
                                                        <span class="badge badge-warning badge-sm">Draft</span>
                                                        @break
                                                    @case('archived')
                                                        <span class="badge badge-secondary badge-sm">Archived</span>
                                                        @break
                                                @endswitch
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            <!-- Breadcrumb Preview -->
                            @if($page->getBreadcrumbs()->count() > 1)
                            <div class="card {{ $page->featured_image || $page->children->count() > 0 ? 'mt-3' : '' }}">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Breadcrumb Preview</h5>
                                </div>
                                <div class="card-body">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            @foreach($page->getBreadcrumbs() as $breadcrumb)
                                                @if($loop->last)
                                                    <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                                                @else
                                                    <li class="breadcrumb-item">
                                                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            @endif

                            <!-- Actions -->
                            <div class="card {{ $page->featured_image || $page->children->count() > 0 || $page->getBreadcrumbs()->count() > 1 ? 'mt-3' : '' }}">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Aksi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit Halaman
                                        </a>

                                        <form action="{{ route('admin.pages.duplicate', $page) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm w-100">
                                                <i class="fas fa-copy"></i> Duplikasi
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.pages.toggle-status', $page) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-{{ $page->status == 'published' ? 'secondary' : 'success' }} btn-sm w-100">
                                                @if($page->status == 'published')
                                                    <i class="fas fa-eye-slash"></i> Unpublish
                                                @else
                                                    <i class="fas fa-eye"></i> Publish
                                                @endif
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
.content-preview {
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    padding: 1rem;
    background-color: #f8f9fa;
    max-height: 400px;
    overflow-y: auto;
}

.content-preview img {
    max-width: 100%;
    height: auto;
}

.content-preview h1,
.content-preview h2,
.content-preview h3,
.content-preview h4,
.content-preview h5,
.content-preview h6 {
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}

.content-preview p {
    margin-bottom: 1rem;
}
</style>
@endsection
