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
                                                {{ old('content', '') }}
                                            </div>
                                            <textarea name="content" style="display: none;">{{ old('content', '') }}</textarea>
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
<!-- CKEditor 5 CDN with Image Support -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Custom Upload Adapter for CKEditor 5
    class CustomUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file.then(file => new Promise((resolve, reject) => {
                this._initRequest();
                this._initListeners(resolve, reject, file);
                this._sendRequest(file);
            }));
        }

        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }

        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();

            // Detect current protocol and construct URL accordingly
            const protocol = window.location.protocol;
            const host = window.location.host;
            const uploadPath = '{{ str_replace(url("/"), "", route("admin.pages.upload.image")) }}';
            const uploadUrl = protocol + '//' + host + uploadPath;

            console.log('Upload URL:', uploadUrl);

            xhr.open('POST', uploadUrl, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.responseType = 'json';
        }

        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = 'Could not upload file: ' + file.name + '.';

            xhr.addEventListener('error', () => {
                console.error('Upload network error for file:', file.name);
                reject(genericErrorText);
            });

            xhr.addEventListener('abort', () => {
                console.log('Upload aborted for file:', file.name);
                reject();
            });

            xhr.addEventListener('load', () => {
                const response = xhr.response;
                console.log('Upload response:', response, 'Status:', xhr.status);

                if (xhr.status !== 200 || !response || response.error) {
                    const errorMsg = response && response.error ? response.error.message : genericErrorText;
                    console.error('Upload failed:', errorMsg);
                    return reject(errorMsg);
                }

                if (!response.url) {
                    console.error('Upload response missing URL:', response);
                    return reject('Server response missing image URL');
                }

                console.log('Upload successful:', response.url);
                resolve({
                    default: response.url
                });
            });

            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }

        _sendRequest(file) {
            const data = new FormData();
            data.append('upload', file);
            this.xhr.send(data);
        }
    }

    function CustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new CustomUploadAdapter(loader);
        };
    }

    // Initialize CKEditor 5 with Image Support
    ClassicEditor
        .create(document.querySelector('#content'), {
            extraPlugins: [CustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    '|',
                    'uploadImage',
                    'insertImage',
                    '|',
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
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    '|',
                    'resizeImage:50',
                    'resizeImage:75',
                    'resizeImage:original'
                ],
                resizeOptions: [
                    {
                        name: 'resizeImage:original',
                        label: 'Original size',
                        value: null
                    },
                    {
                        name: 'resizeImage:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'resizeImage:75',
                        label: '75%',
                        value: '75'
                    }
                ]
            },
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

            // Sync function
            function syncContent() {
                const hiddenTextarea = document.querySelector('textarea[name="content"]');
                if (hiddenTextarea && editor) {
                    const content = editor.getData();
                    hiddenTextarea.value = content;
                    console.log('Content synced:', content.length + ' characters');
                    return true;
                }
                return false;
            }

            // Sync on editor change (auto-sync)
            editor.model.document.on('change:data', () => {
                syncContent();
            });

            // Sync on form submit
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submitting, syncing content...');
                    const hiddenTextarea = document.querySelector('textarea[name="content"]');
                    const editorContent = editor.getData();
                    
                    console.log('Editor content length:', editorContent.length);
                    console.log('Editor content preview:', editorContent.substring(0, 100) + '...');
                    
                    if (!syncContent()) {
                        console.error('Failed to sync content!');
                        e.preventDefault();
                        alert('Gagal menyinkronkan konten. Silakan coba lagi.');
                        return false;
                    }
                    
                    console.log('Final textarea value:', hiddenTextarea.value.substring(0, 100) + '...');
                });
            }

            // Add manual sync button for debugging
            const syncButton = document.createElement('button');
            syncButton.type = 'button';
            syncButton.className = 'btn btn-info btn-sm mt-2';
            syncButton.innerHTML = '🔄 Sync Manual (Debug)';
            syncButton.onclick = function() {
                const content = editor.getData();
                const hiddenTextarea = document.querySelector('textarea[name="content"]');
                
                console.log('Manual sync triggered');
                console.log('Editor content:', content);
                console.log('Hidden textarea before:', hiddenTextarea.value);
                
                if (syncContent()) {
                    console.log('Hidden textarea after:', hiddenTextarea.value);
                    alert(`Konten berhasil disinkronkan!\nPanjang: ${content.length} karakter\nPreview: ${content.substring(0, 50)}...`);
                } else {
                    alert('Gagal menyinkronkan konten!');
                }
            };

            // Insert sync button after the editor
            const editorDiv = document.getElementById('content');
            if (editorDiv && editorDiv.parentNode) {
                editorDiv.parentNode.insertBefore(syncButton, editorDiv.nextSibling);
            }

            // Add form validation
            form.addEventListener('submit', function(e) {
                const titleValue = document.getElementById('title').value.trim();
                const contentValue = editor.getData().trim();
                
                if (!titleValue) {
                    alert('Judul halaman harus diisi!');
                    e.preventDefault();
                    return false;
                }
                
                if (!contentValue) {
                    alert('Konten halaman harus diisi!');
                    e.preventDefault();
                    return false;
                }
                
                console.log('Form validation passed, content length:', contentValue.length);
            });

            // Make sync function globally available
            window.syncEditorContent = syncContent;
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
#content {
    min-height: 400px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 15px;
}

#content:empty:before {
    content: "Mulai menulis konten di sini...";
    color: #999;
    font-style: italic;
}

.ck-editor__editable {
    min-height: 400px;
}
.ck-content {
    font-size: 16px;
    line-height: 1.6;
}

/* Custom CSS untuk tabel yang menarik */
.ck-content table {
    overflow: hidden;
    border-radius: 12px !important;
}

/* Image Styling */
.ck-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    margin: 10px 0;
}

.ck-content img:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    transform: scale(1.02);
}

.ck-content figure.image {
    margin: 20px 0;
    text-align: center;
}

.ck-content figure.image.image-style-side {
    max-width: 50%;
    float: right;
    margin: 0 0 20px 20px;
}

.ck-content figure.image.image-style-side.image-style-align-left {
    float: left;
    margin: 0 20px 20px 0;
}

.ck-content figure.image figcaption {
    background: #f8f9fa;
    color: #6c757d;
    font-size: 14px;
    font-style: italic;
    padding: 8px 12px;
    border-radius: 0 0 8px 8px;
    margin-top: -5px;
    text-align: center;
}

/* Image upload progress */
.ck-content .ck-upload-placeholder {
    background: linear-gradient(135deg, #e7f3ff, #f0f9ff);
    border: 2px dashed #1e5631;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    color: #1e5631;
}

.ck-content table tr:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(30, 86, 49, 0.15);
}

.ck-content table tbody tr {
    transition: all 0.3s ease !important;
}

.ck-content table tbody tr:hover {
    background: linear-gradient(135deg, #f0fff4, #e6fffa) !important;
}

.ck-content table a {
    transition: all 0.3s ease;
    display: inline-block;
}

.ck-content table a:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
}

/* Animasi untuk button actions */
.ck-content table a[style*="background: linear-gradient(135deg, #4299e1"]:hover {
    background: linear-gradient(135deg, #3182ce, #2c5282) !important;
}

.ck-content table a[style*="background: linear-gradient(135deg, #ed8936"]:hover {
    background: linear-gradient(135deg, #dd6b20, #c05621) !important;
}

.ck-content table a[style*="background: linear-gradient(135deg, #48bb78"]:hover {
    background: linear-gradient(135deg, #38a169, #2f855a) !important;
}

.ck-content table a[style*="background: linear-gradient(135deg, #9f7aea"]:hover {
    background: linear-gradient(135deg, #805ad5, #6b46c1) !important;
}

.ck-content table a[style*="background: linear-gradient(135deg, #f56565"]:hover {
    background: linear-gradient(135deg, #e53e3e, #c53030) !important;
}

/* Animasi untuk header tabel */
.ck-content table thead tr {
    position: relative;
    overflow: hidden;
}

.ck-content table thead tr::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.ck-content table:hover thead tr::before {
    left: 100%;
}

/* Style untuk list items */
.ck-content ul li {
    transition: all 0.3s ease;
    border-radius: 8px;
    margin-bottom: 12px;
}

.ck-content ul li:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 10px rgba(30, 86, 49, 0.1);
}

/* Efek parallax untuk gradient background */
.ck-content div[style*="background: linear-gradient"] {
    background-attachment: fixed !important;
    position: relative;
    overflow: hidden;
}

.ck-content div[style*="background: linear-gradient"]::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
    pointer-events: none;
}

@keyframes float {
    0%, 100% { transform: translate(0px, 0px) rotate(0deg); }
    33% { transform: translate(30px, -30px) rotate(120deg); }
    66% { transform: translate(-20px, 20px) rotate(240deg); }
}

/* Pulse animation untuk icons */
.ck-content h2, .ck-content h3 {
    position: relative;
}

.ck-content h2::before,
.ck-content h3::before {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #1e5631, #2d8f47);
    transition: width 0.5s ease;
}

.ck-content h2:hover::before,
.ck-content h3:hover::before {
    width: 100%;
}

/* Smooth scroll untuk long content */
.ck-content {
    scroll-behavior: smooth;
}

/* Modern scrollbar untuk overflow areas */
.ck-content div[style*="overflow-x: auto"]::-webkit-scrollbar {
    height: 6px;
}

.ck-content div[style*="overflow-x: auto"]::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.ck-content div[style*="overflow-x: auto"]::-webkit-scrollbar-thumb {
    background: linear-gradient(90deg, #1e5631, #2d8f47);
    border-radius: 3px;
}

.ck-content div[style*="overflow-x: auto"]::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(90deg, #2d8f47, #1e5631);
}

/* Loading animation untuk table */
.ck-content table {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive improvements */
@media (max-width: 768px) {
    .ck-content table {
        font-size: 14px;
    }

    .ck-content table th,
    .ck-content table td {
        padding: 12px 8px !important;
    }

    .ck-content h2 {
        font-size: 24px !important;
    }

    .ck-content h3 {
        font-size: 20px !important;
    }
}

/* Focus states untuk accessibility */
.ck-content table a:focus {
    outline: 2px solid #1e5631;
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .ck-content table {
        box-shadow: none !important;
        border: 1px solid #000 !important;
    }

    .ck-content table th {
        background: #f0f0f0 !important;
        color: #000 !important;
    }
}
</style>
@endsection
