@extends('admin.layouts.app')

@section('title', 'Tambah Halaman')
@section('page-title', 'Tambah Halaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">Kelola Halaman</a></li>
    <li class="breadcrumb-item active">Tambah Halaman</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Halaman Baru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Informasi Dasar</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title">Judul Halaman <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                   id="title" name="title" value="{{ old('title') }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="slug">URL Slug</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                   id="slug" name="slug" value="{{ old('slug') }}"
                                                   placeholder="Kosongkan untuk auto-generate">
                                            <small class="text-muted">URL akan menjadi: <span id="preview-url">{{ url('/') }}/</span></small>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="excerpt">Ringkasan</label>
                                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                                      id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                                            <small class="text-muted">Ringkasan singkat untuk SEO dan preview</small>
                                            @error('excerpt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="content">Konten</label>
                                            <div id="content" class="@error('content') is-invalid @enderror">
                                                {!! old('content', '<h2>Judul Halaman</h2><p>Masukkan konten halaman di sini. Anda dapat menggunakan editor untuk formatting yang lebih baik.</p>') !!}
                                            </div>
                                            <textarea name="content" style="display: none;">{{ old('content', '<h2>Judul Halaman</h2><p>Masukkan konten halaman di sini. Anda dapat menggunakan editor untuk formatting yang lebih baik.</p>') }}</textarea>
                                            <small class="text-muted">Gunakan rich text editor untuk formatting yang lebih baik</small>
                                            @error('content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Section -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">SEO Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                                            @error('meta_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                                      id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                                            @error('meta_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                                                   placeholder="Pisahkan dengan koma">
                                            @error('meta_keywords')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Publish Settings -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Pengaturan Publikasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required>
                                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="published_at">Tanggal Publikasi</label>
                                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                                   id="published_at" name="published_at" value="{{ old('published_at') }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="template">Template</label>
                                            <select class="form-control @error('template') is-invalid @enderror" 
                                                    id="template" name="template" required>
                                                @foreach($templateOptions as $key => $label)
                                                    <option value="{{ $key }}" {{ old('template') == $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('template')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="parent_id">Parent Page</label>
                                            <select class="form-control @error('parent_id') is-invalid @enderror" 
                                                    id="parent_id" name="parent_id">
                                                <option value="">Root Page</option>
                                                @foreach($parentPages as $id => $title)
                                                    <option value="{{ $id }}" {{ old('parent_id') == $id ? 'selected' : '' }}>
                                                        {{ $title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="sort_order">Urutan</label>
                                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 1) }}" min="1">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" 
                                                   id="show_in_menu" name="show_in_menu" value="1" 
                                                   {{ old('show_in_menu', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_in_menu">
                                                Tampilkan di Menu
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" 
                                                   id="is_homepage" name="is_homepage" value="1" 
                                                   {{ old('is_homepage') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_homepage">
                                                Jadikan Homepage
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Featured Image -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Featured Image</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="file" class="form-control-file @error('featured_image') is-invalid @enderror"
                                                   id="featured_image" name="featured_image" accept="image/*">
                                            <small class="text-muted">Max: 2MB, Format: JPG, PNG, GIF</small>
                                            @error('featured_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div id="image-preview" class="mt-2" style="display: none;">
                                            <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Halaman
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize CKEditor 5
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'outdent',
                    'indent',
                    '|',
                    'blockQuote',
                    'insertTable',
                    '|',
                    'undo',
                    'redo',
                    'sourceEditing'
                ]
            },
            language: 'en',
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            }
        })
        .then(editor => {
            console.log('CKEditor 5 initialized successfully!');
            window.editor = editor;
            
            // Sync editor content to hidden textarea on form submit
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const hiddenTextarea = document.querySelector('textarea[name="content"]');
                    if (hiddenTextarea) {
                        hiddenTextarea.value = editor.getData();
                    }
                });
            }
        })
        .catch(error => {
            console.error('CKEditor 5 initialization failed:', error);
        });

    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const previewUrl = document.getElementById('preview-url');

    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.auto !== 'false') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            
            slugInput.value = slug;
            previewUrl.textContent = '{{ url("/") }}/' + slug;
        }
    });

    slugInput.addEventListener('input', function() {
        this.dataset.auto = 'false';
        previewUrl.textContent = '{{ url("/") }}/' + this.value;
    });

    // Image preview
    const imageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('image-preview');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
});
</script>

<style>
.ck-editor__editable {
    min-height: 400px;
}
.ck-content {
    font-size: 16px;
    line-height: 1.6;
}
</style>
@endsection
