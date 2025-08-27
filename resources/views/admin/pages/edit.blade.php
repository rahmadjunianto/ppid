@extends('admin.layouts.app')

@section('title', 'Edit Halaman')
@section('page-title', 'Edit Halaman')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">Kelola Halaman</a></li>
    <li class="breadcrumb-item active">Edit Halaman</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Halaman: {{ $page->title }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Preview
                        </a>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                        <h5 class="card-title mb-0">Informasi Dasar</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title">Judul Halaman <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                   id="title" name="title" value="{{ old('title', $page->title) }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="slug">URL Slug</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                   id="slug" name="slug" value="{{ old('slug', $page->slug) }}"
                                                   data-auto="false">
                                            <small class="text-muted">URL akan menjadi: <span id="preview-url">{{ url('/') }}/{{ $page->slug }}</span></small>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="excerpt">Ringkasan</label>
                                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                                      id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $page->excerpt) }}</textarea>
                                            <small class="text-muted">Ringkasan singkat untuk SEO dan preview</small>
                                            @error('excerpt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="content">Konten</label>
                                            <textarea class="form-control @error('content') is-invalid @enderror"
                                                      id="content" name="content" rows="15">{{ old('content', $page->content) }}</textarea>
                                            <small class="text-muted">Gunakan editor untuk formatting yang lebih baik</small>
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
                                                   id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
                                            @error('meta_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                                      id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                                            @error('meta_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}"
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
                                                <option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="archived" {{ old('status', $page->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="published_at">Tanggal Publikasi</label>
                                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                                   id="published_at" name="published_at"
                                                   value="{{ old('published_at', $page->published_at ? $page->published_at->format('Y-m-d\TH:i') : '') }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="template">Template</label>
                                            <select class="form-control @error('template') is-invalid @enderror"
                                                    id="template" name="template" required>
                                                @foreach($templateOptions as $key => $label)
                                                    <option value="{{ $key }}" {{ old('template', $page->template) == $key ? 'selected' : '' }}>
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
                                                    <option value="{{ $id }}" {{ old('parent_id', $page->parent_id) == $id ? 'selected' : '' }}>
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
                                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" min="1">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                   id="show_in_menu" name="show_in_menu" value="1"
                                                   {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_in_menu">
                                                Tampilkan di Menu
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                   id="is_homepage" name="is_homepage" value="1"
                                                   {{ old('is_homepage', $page->is_homepage) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_homepage">
                                                Jadikan Homepage
                                            </label>
                                        </div>

                                        <!-- Page Statistics -->
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <strong>Dibuat:</strong> {{ $page->created_at->format('d M Y H:i') }}<br>
                                                <strong>Diupdate:</strong> {{ $page->updated_at->format('d M Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Featured Image -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Featured Image</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($page->featured_image)
                                            <div class="current-image mb-3">
                                                <img src="{{ asset('storage/' . $page->featured_image) }}"
                                                     alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                                                <div class="mt-2">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="remove_image" value="1">
                                                        Hapus gambar saat ini
                                                    </label>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="featured_image">Upload Gambar Baru</label>
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
                            <i class="fas fa-save"></i> Update Halaman
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
<!-- CKEditor 5 Classic with Image Resize -->
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

    // Initialize CKEditor 5 Classic
    ClassicEditor
        .create(document.querySelector('#content'), {
            extraPlugins: [CustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    '|',
                    'fontSize',
                    'fontColor',
                    'fontBackgroundColor',
                    '|',
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
                    'alignment',
                    '|',
                    'blockQuote',
                    'insertTable',
                    '|',
                    'undo',
                    'redo',
                    '|',
                    'sourceEditing'
                ]
            },
            language: 'en',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    '|',
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    '|',
                    'imageStyle:alignLeft',
                    'imageStyle:alignCenter',
                    'imageStyle:alignRight',
                    '|',
                    'resizeImage:25',
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
                        name: 'resizeImage:25',
                        label: '25%',
                        value: '25'
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
                ],
                styles: [
                    'alignLeft',
                    'alignCenter',
                    'alignRight'
                ]
            },
            fontSize: {
                options: [9, 10, 11, 12, 13, 14, 'default', 16, 18, 20, 22, 24, 26, 28, 36, 48, 72]
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
            console.log('CKEditor 5 initialized successfully with image resize!');
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

            // Show success message
            setTimeout(() => {
                showNotification('CKEditor siap! Fitur upload dan resize gambar tersedia.', 'success');
            }, 1000);
        })
        .catch(error => {
            console.error('CKEditor 5 initialization failed:', error);

            // Fallback to simple textarea if CKEditor fails
            const textarea = document.querySelector('#content');
            if (textarea) {
                textarea.style.display = 'block';
                textarea.style.minHeight = '400px';
                showNotification('CKEditor gagal dimuat, menggunakan textarea biasa.', 'warning');
            }
        });

    // Auto-generate slug from title (only if not manually edited)
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const previewUrl = document.getElementById('preview-url');

    if (titleInput && slugInput && previewUrl) {
        titleInput.addEventListener('input', function() {
            if (slugInput.dataset.auto !== 'false') {
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
    }

    // Featured Image preview
    const imageInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('image-preview');

    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = imagePreview.querySelector('img');
                    if (img) {
                        img.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    }

    // Helper function for notifications
    function showNotification(message, type) {
        const colors = {
            success: '#28a745',
            error: '#dc3545',
            info: '#17a2b8',
            warning: '#ffc107'
        };

        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${colors[type] || colors.info};
            color: ${type === 'warning' ? '#000' : '#fff'};
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 10000;
            max-width: 300px;
            font-size: 14px;
            animation: slideIn 0.3s ease;
        `;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
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

/* Enhanced styling for images with resize functionality */
.ck-content .image {
    display: table;
    clear: both;
    text-align: center;
    margin: 1em auto;
}

.ck-content .image img {
    display: block;
    margin: 0 auto;
    max-width: 100%;
    min-width: 50px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.ck-content .image-inline {
    display: inline-block;
    align-items: flex-start;
    max-width: 100%;
    margin-left: 0;
    margin-right: 0;
}

.ck-content .image-style-side {
    float: right;
    margin: 0 0 1em 1em;
    max-width: 50%;
}

.ck-content .image-style-align-left {
    float: left;
    margin: 0 1em 1em 0;
}

.ck-content .image-style-align-center {
    margin: 1em auto;
    display: block;
}

.ck-content .image-style-align-right {
    float: right;
    margin: 0 0 1em 1em;
}

/* Responsive images */
@media (max-width: 768px) {
    .ck-content .image-style-side,
    .ck-content .image-style-align-left,
    .ck-content .image-style-align-right {
        float: none;
        margin: 1em auto;
        max-width: 100%;
        display: block;
    }
}

/* Fallback textarea styling */
#content {
    display: none;
}

#content.fallback {
    display: block !important;
    width: 100%;
    min-height: 400px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: Arial, sans-serif;
    font-size: 14px;
    line-height: 1.6;
}
</style>
@endsection
