<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Demo Image Upload & Resize - CKEditor 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="text-white mb-3">
                        <i class="fas fa-images me-3"></i>
                        Demo Image Upload & Resize
                    </h1>
                    <p class="text-white-50 fs-5">
                        CKEditor 5 dengan fitur upload gambar dan resize lengkap
                    </p>
                </div>

                <!-- Main Card -->
                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white" style="border-radius: 20px 20px 0 0;">
                        <h3 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Rich Text Editor dengan Image Features
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- Instructions -->
                        <div class="alert alert-info border-0 mb-4" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb);">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>
                                Cara Menggunakan:
                            </h5>
                            <ul class="mb-0">
                                <li><strong>Upload Image:</strong> Klik tombol image di toolbar atau drag & drop</li>
                                <li><strong>Resize:</strong> Klik gambar → pilih ukuran (25%, 50%, 75%, Original)</li>
                                <li><strong>Positioning:</strong> Pilih alignment (Left, Center, Right, Side)</li>
                                <li><strong>Alt Text:</strong> Klik gambar → edit alternative text untuk SEO</li>
                            </ul>
                        </div>

                        <!-- Form -->
                        <form id="demo-form">
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Judul Konten</label>
                                <input type="text" class="form-control" id="title" value="Demo Konten dengan Gambar">
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label fw-bold">Konten dengan CKEditor 5</label>
                                <div id="editor-container">
                                    <textarea id="content" name="content">
<h2 style="text-align: center; color: #1e5631;">🖼️ Demo Image Upload & Resize Features</h2>

<p>Ini adalah demo untuk menguji semua fitur gambar di CKEditor 5. Anda dapat:</p>

<ul>
    <li><strong>Upload gambar</strong> dengan drag & drop atau klik tombol upload</li>
    <li><strong>Resize gambar</strong> ke berbagai ukuran (25%, 50%, 75%, original)</li>
    <li><strong>Posisi gambar</strong> (inline, block, side, left, center, right)</li>
    <li><strong>Alt text</strong> untuk SEO dan accessibility</li>
</ul>

<blockquote>
    <p>💡 <strong>Tips:</strong> Setelah upload gambar, klik pada gambar untuk melihat toolbar dengan opsi resize dan positioning!</p>
</blockquote>

<h3>Contoh Gambar dengan Berbagai Ukuran:</h3>

<p>Silakan upload gambar dan coba semua fitur yang tersedia. Gambar akan otomatis tersimpan di server dan dapat digunakan di halaman lain.</p>

<hr>

<p style="text-align: center; font-style: italic; color: #666;">
    Upload gambar Anda di sini dan eksplorasi semua fitur yang tersedia! 📸
</p>
                                    </textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-success" onclick="saveContent()">
                                    <i class="fas fa-save me-2"></i>Simpan Konten
                                </button>
                                <button type="button" class="btn btn-info" onclick="previewContent()">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </button>
                                <button type="button" class="btn btn-warning" onclick="getImageInfo()">
                                    <i class="fas fa-info me-2"></i>Info Gambar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Features Info -->
                <div class="row mt-5">
                    <div class="col-md-3">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="display-6 text-primary mb-3">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <h5>Upload</h5>
                                <p class="text-muted">Drag & drop atau klik upload</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="display-6 text-success mb-3">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </div>
                                <h5>Resize</h5>
                                <p class="text-muted">25%, 50%, 75%, Original</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="display-6 text-warning mb-3">
                                    <i class="fas fa-align-center"></i>
                                </div>
                                <h5>Positioning</h5>
                                <p class="text-muted">Left, Center, Right, Side</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="display-6 text-danger mb-3">
                                    <i class="fas fa-universal-access"></i>
                                </div>
                                <h5>Alt Text</h5>
                                <p class="text-muted">SEO & Accessibility</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CKEditor 5 CDN with Image Resize Plugin -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/translations/id.js"></script>
    <script>
        let editorInstance;

        // Import CKEditor 5 modules
        const {
            ClassicEditor,
            Essentials,
            Bold,
            Italic,
            Font,
            Paragraph,
            Image,
            ImageCaption,
            ImageResize,
            ImageStyle,
            ImageToolbar,
            ImageUpload,
            ImageInsert,
            PictureEditing,
            LinkImage
        } = window.CKEDITOR;

        // Custom Upload Adapter
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
                xhr.open('POST', '{{ route("admin.pages.upload.image") }}', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.responseType = 'json';
            }

            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = 'Could not upload file: ' + file.name + '.';

                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;

                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }

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

        // Initialize CKEditor 5 with Image Resize
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
                        'strikethrough',
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
                        'horizontalLine',
                        '|',
                        'undo',
                        'redo',
                        '|',
                        'sourceEditing'
                    ]
                },
                language: 'en',
                image: {
                    resizeUnit: '%',
                    resizeOptions: [
                        {
                            name: 'resizeImage:original',
                            value: null,
                            label: 'Original'
                        },
                        {
                            name: 'resizeImage:25',
                            value: '25',
                            label: '25%'
                        },
                        {
                            name: 'resizeImage:50',
                            value: '50',
                            label: '50%'
                        },
                        {
                            name: 'resizeImage:75',
                            value: '75',
                            label: '75%'
                        }
                    ],
                    toolbar: [
                        'imageTextAlternative',
                        '|',
                        'imageStyle:inline',
                        'imageStyle:wrapText',
                        'imageStyle:breakText',
                        '|',
                        'resizeImage'
                    ],
                    styles: [
                        'alignLeft',
                        'alignCenter',
                        'alignRight'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableCellProperties',
                        'tableProperties'
                    ]
                },
                fontSize: {
                    options: [9, 10, 11, 12, 13, 14, 'default', 16, 18, 20, 22, 24, 26, 28, 36, 48, 72]
                }
            })
            .then(editor => {
                console.log('CKEditor 5 initialized successfully with advanced image features!');
                editorInstance = editor;
                window.editor = editor;

                // Image upload progress notification
                editor.plugins.get('FileRepository').on('change:uploaded', (evt, name, value, oldValue) => {
                    if (value > oldValue) {
                        console.log(`Upload progress: ${Math.round(value)}%`);
                    }
                });

                // Image upload complete notification
                editor.plugins.get('FileRepository').on('change:uploadTotal', (evt, name, value) => {
                    if (value === editor.plugins.get('FileRepository').uploaded) {
                        console.log('Image upload completed!');
                        showNotification('Gambar berhasil diupload!', 'success');
                    }
                });
            })
            .catch(error => {
                console.error('CKEditor 5 initialization failed:', error);
                showNotification('Gagal menginisialisasi editor!', 'error');
            });

        // Helper functions
        function saveContent() {
            if (editorInstance) {
                const content = editorInstance.getData();
                console.log('Content saved:', content);
                showNotification('Konten berhasil disimpan!', 'success');

                // You can send this to server here
                // fetch('/save-content', { method: 'POST', body: content })
            }
        }

        function previewContent() {
            if (editorInstance) {
                const content = editorInstance.getData();
                const newWindow = window.open('', '_blank');
                newWindow.document.write(`
                    <html>
                        <head>
                            <title>Preview Content</title>
                            <style>
                                body { font-family: Arial, sans-serif; padding: 20px; line-height: 1.6; }
                                img { max-width: 100%; height: auto; }
                            </style>
                        </head>
                        <body>${content}</body>
                    </html>
                `);
                newWindow.document.close();
            }
        }

        function getImageInfo() {
            if (editorInstance) {
                const content = editorInstance.getData();
                const imageMatches = content.match(/<img[^>]+>/g);

                if (imageMatches) {
                    let info = `Ditemukan ${imageMatches.length} gambar:\n\n`;
                    imageMatches.forEach((img, index) => {
                        const src = img.match(/src="([^"]+)"/)?.[1] || 'No src';
                        const alt = img.match(/alt="([^"]+)"/)?.[1] || 'No alt text';
                        const style = img.match(/style="([^"]+)"/)?.[1] || 'No style';
                        info += `${index + 1}. Src: ${src}\n   Alt: ${alt}\n   Style: ${style}\n\n`;
                    });
                    alert(info);
                } else {
                    alert('Tidak ada gambar ditemukan dalam konten.');
                }
            }
        }

        function showNotification(message, type) {
            const colors = {
                success: '#28a745',
                error: '#dc3545',
                info: '#17a2b8'
            };

            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${colors[type] || colors.info};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                z-index: 10000;
                animation: slideIn 0.3s ease;
            `;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
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

            .ck-editor__editable {
                min-height: 400px;
                font-size: 16px;
                line-height: 1.6;
            }

            .ck-content .image {
                margin: 20px auto;
            }

            .ck-content .image img {
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }

            .ck-content .image-style-side {
                float: right;
                margin: 0 0 20px 20px;
                max-width: 50%;
            }

            .ck-content .image-style-align-left {
                float: left;
                margin: 0 20px 20px 0;
            }

            .ck-content .image-style-align-center {
                margin: 20px auto;
                display: block;
            }

            .ck-content .image-style-align-right {
                float: right;
                margin: 0 0 20px 20px;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
