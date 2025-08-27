<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Demo CKEditor 5 Working - Image Upload & Resize</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); min-height: 100vh;">
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="text-white mb-3">
                        <i class="fas fa-check-circle me-3"></i>
                        Demo CKEditor 5 Working Version
                    </h1>
                    <p class="text-white-50 fs-5">
                        Versi yang pasti bekerja dengan fitur upload dan resize gambar
                    </p>
                </div>

                <!-- Main Card -->
                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-header bg-success text-white" style="border-radius: 20px 20px 0 0;">
                        <h3 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            CKEditor 5 Classic - Stable Version
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- Status Info -->
                        <div class="alert alert-info border-0 mb-4">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>
                                Status Editor:
                            </h5>
                            <div id="editor-status" class="mb-3">
                                <span class="badge bg-warning">Loading...</span>
                            </div>
                            <ul class="mb-0">
                                <li><strong>Upload Image:</strong> Drag & drop atau klik tombol upload</li>
                                <li><strong>Resize Image:</strong> Klik gambar untuk melihat toolbar resize</li>
                                <li><strong>Styles:</strong> Pilih alignment dan positioning</li>
                            </ul>
                        </div>

                        <!-- Form -->
                        <form id="demo-form">
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Judul Konten</label>
                                <input type="text" class="form-control" id="title" value="Test CKEditor 5 Working">
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label fw-bold">Rich Text Editor</label>
                                <div id="editor-container">
                                    <textarea id="content">
<h2>🎉 CKEditor 5 Berhasil Dimuat!</h2>

<p>Jika Anda melihat toolbar rich text editor di atas, berarti CKEditor 5 berhasil dimuat dengan fitur:</p>

<ul>
    <li><strong>Upload Image:</strong> Klik tombol upload atau drag & drop gambar</li>
    <li><strong>Resize Image:</strong> Setelah upload, klik gambar untuk resize</li>
    <li><strong>Text Formatting:</strong> Bold, italic, heading, dll</li>
    <li><strong>Lists & Tables:</strong> Bullet points, numbered lists, tables</li>
</ul>

<blockquote>
    <p>💡 <strong>Tips:</strong> Upload gambar dan klik pada gambar untuk melihat toolbar dengan opsi resize!</p>
</blockquote>

<p>Silakan coba semua fitur yang tersedia!</p>
                                    </textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-success" onclick="saveContent()">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                                <button type="button" class="btn btn-info" onclick="showHTML()">
                                    <i class="fas fa-code me-2"></i>Lihat HTML
                                </button>
                                <button type="button" class="btn btn-warning" onclick="testUpload()">
                                    <i class="fas fa-upload me-2"></i>Test Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Debug Info -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-bug me-2"></i>Debug Information</h6>
                            </div>
                            <div class="card-body">
                                <div id="debug-info">
                                    <p class="text-muted">Loading debug information...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CKEditor 5 Classic Build -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        let editorInstance = null;

        // Update status
        function updateStatus(message, type = 'info') {
            const statusEl = document.getElementById('editor-status');
            const colors = {
                success: 'bg-success',
                error: 'bg-danger',
                warning: 'bg-warning',
                info: 'bg-info'
            };
            statusEl.innerHTML = `<span class="badge ${colors[type]}">${message}</span>`;
        }

        // Update debug info
        function updateDebug(message) {
            const debugEl = document.getElementById('debug-info');
            const timestamp = new Date().toLocaleTimeString();
            debugEl.innerHTML += `<div class="small text-muted">[${timestamp}] ${message}</div>`;
        }

        // Custom Upload Adapter
        class CustomUploadAdapter {
            constructor(loader) {
                this.loader = loader;
                updateDebug('Upload adapter created');
            }

            upload() {
                updateDebug('Starting upload...');
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
            }

            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                    updateDebug('Upload aborted');
                }
            }

            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route("admin.pages.upload.image") }}', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.responseType = 'json';
                updateDebug('Upload request initialized');
            }

            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = 'Could not upload file: ' + file.name + '.';

                xhr.addEventListener('error', () => {
                    updateDebug('Upload error occurred');
                    reject(genericErrorText);
                });
                xhr.addEventListener('abort', () => {
                    updateDebug('Upload was aborted');
                    reject();
                });
                xhr.addEventListener('load', () => {
                    const response = xhr.response;
                    updateDebug(`Upload response: ${JSON.stringify(response)}`);

                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }

                    updateDebug('Upload successful!');
                    resolve({
                        default: response.url
                    });
                });

                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                            const progress = Math.round((evt.loaded / evt.total) * 100);
                            updateDebug(`Upload progress: ${progress}%`);
                        }
                    });
                }
            }

            _sendRequest(file) {
                const data = new FormData();
                data.append('upload', file);
                this.xhr.send(data);
                updateDebug(`Sending file: ${file.name} (${file.size} bytes)`);
            }
        }

        function CustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new CustomUploadAdapter(loader);
            };
        }

        // Initialize CKEditor
        document.addEventListener('DOMContentLoaded', function() {
            updateStatus('Initializing CKEditor...', 'warning');
            updateDebug('DOM loaded, starting CKEditor initialization');

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
                            'redo'
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
                            'imageStyle:alignRight'
                        ],
                        styles: [
                            'alignLeft',
                            'alignCenter',
                            'alignRight'
                        ]
                    },
                    fontSize: {
                        options: [9, 10, 11, 12, 13, 14, 'default', 16, 18, 20, 22, 24]
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
                    updateStatus('CKEditor loaded successfully!', 'success');
                    updateDebug('CKEditor initialized successfully');

                    editorInstance = editor;
                    window.editor = editor;

                    // Add event listeners
                    editor.model.document.on('change:data', () => {
                        updateDebug('Content changed');
                    });

                    // Image upload events
                    const fileRepository = editor.plugins.get('FileRepository');
                    fileRepository.on('change:uploaded', (evt, name, value, oldValue) => {
                        if (value > oldValue) {
                            updateDebug(`Upload progress: ${Math.round(value)}%`);
                        }
                    });

                    fileRepository.on('change:uploadTotal', (evt, name, value) => {
                        if (value === fileRepository.uploaded) {
                            updateDebug('Upload completed!');
                            showNotification('Gambar berhasil diupload!', 'success');
                        }
                    });

                    // Show initial notification
                    setTimeout(() => {
                        showNotification('CKEditor siap digunakan! Upload gambar untuk test fitur.', 'info');
                    }, 1000);
                })
                .catch(error => {
                    updateStatus('CKEditor failed to load!', 'error');
                    updateDebug(`Error: ${error.message}`);
                    console.error('CKEditor initialization error:', error);

                    // Show fallback
                    const textarea = document.querySelector('#content');
                    if (textarea) {
                        textarea.style.display = 'block';
                        textarea.style.minHeight = '300px';
                        textarea.className = 'form-control';
                        showNotification('CKEditor gagal dimuat. Menggunakan textarea biasa.', 'error');
                    }
                });
        });

        // Helper functions
        function saveContent() {
            if (editorInstance) {
                const content = editorInstance.getData();
                updateDebug('Content saved');
                showNotification('Konten berhasil disimpan!', 'success');
                console.log('Saved content:', content);
            } else {
                showNotification('Editor belum siap!', 'error');
            }
        }

        function showHTML() {
            if (editorInstance) {
                const content = editorInstance.getData();
                const newWindow = window.open('', '_blank', 'width=800,height=600');
                newWindow.document.write(`
                    <html>
                        <head>
                            <title>HTML Output</title>
                            <style>
                                body { font-family: Arial, sans-serif; padding: 20px; }
                                .code { background: #f5f5f5; padding: 15px; border-radius: 5px; font-family: monospace; white-space: pre-wrap; }
                                .preview { border: 1px solid #ddd; padding: 15px; margin: 20px 0; }
                            </style>
                        </head>
                        <body>
                            <h2>HTML Code:</h2>
                            <div class="code">${content.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</div>
                            <h2>Preview:</h2>
                            <div class="preview">${content}</div>
                        </body>
                    </html>
                `);
                newWindow.document.close();
            }
        }

        function testUpload() {
            if (editorInstance) {
                // Trigger file input
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.accept = 'image/*';
                fileInput.onchange = function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        updateDebug(`Selected file: ${file.name} (${file.size} bytes)`);
                        showNotification(`File selected: ${file.name}`, 'info');
                        // You can trigger manual upload here if needed
                    }
                };
                fileInput.click();
            }
        }

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

        // CSS for animations
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
            }

            #content {
                display: none;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
