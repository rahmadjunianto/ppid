<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Demo Image Resize - CKEditor 5 Superset</title>
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
                        <i class="fas fa-expand-arrows-alt me-3"></i>
                        Demo Image Resize - CKEditor 5 Superset
                    </h1>
                    <p class="text-white-50 fs-5">
                        Versi lengkap dengan semua plugin termasuk Image Resize
                    </p>
                </div>

                <!-- Main Card -->
                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-header bg-success text-white" style="border-radius: 20px 20px 0 0;">
                        <h3 class="mb-0">
                            <i class="fas fa-images me-2"></i>
                            CKEditor 5 Superset - Full Features
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- Instructions -->
                        <div class="alert alert-success border-0 mb-4">
                            <h5 class="alert-heading">
                                <i class="fas fa-lightbulb me-2"></i>
                                Fitur Image Resize Tersedia:
                            </h5>
                            <ul class="mb-0">
                                <li><strong>Upload:</strong> Drag & drop atau klik tombol upload</li>
                                <li><strong>Resize Handle:</strong> Drag pojok gambar untuk resize manual</li>
                                <li><strong>Resize Buttons:</strong> Klik gambar → pilih ukuran dari toolbar</li>
                                <li><strong>Style Options:</strong> Alignment dan text wrapping</li>
                            </ul>
                        </div>

                        <!-- Form -->
                        <form id="demo-form">
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Judul Konten</label>
                                <input type="text" class="form-control" id="title" value="Test Image Resize Features">
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label fw-bold">Editor dengan Image Resize</label>
                                <div id="editor-container">
                                    <textarea id="content">
<h2 style="text-align: center;">🖼️ Test Image Resize di CKEditor 5</h2>

<p>Upload gambar di sini dan test semua fitur resize:</p>

<ol>
    <li><strong>Manual Resize:</strong> Drag pojok gambar untuk resize manual</li>
    <li><strong>Button Resize:</strong> Klik gambar → pilih ukuran dari dropdown</li>
    <li><strong>Style Options:</strong> Pilih alignment dan text wrapping</li>
</ol>

<p>Silakan upload gambar dan coba semua fitur!</p>

<hr>

<p><em>Gambar akan muncul di sini setelah upload...</em></p>
                                    </textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-success" onclick="getEditorData()">
                                    <i class="fas fa-code me-2"></i>Lihat HTML
                                </button>
                                <button type="button" class="btn btn-info" onclick="addSampleImage()">
                                    <i class="fas fa-image me-2"></i>Tambah Sample
                                </button>
                                <button type="button" class="btn btn-warning" onclick="clearEditor()">
                                    <i class="fas fa-trash me-2"></i>Clear
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="display-6 text-success mb-3">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </div>
                                <h5>Manual Resize</h5>
                                <p class="text-muted small">Drag handle di pojok gambar</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="display-6 text-primary mb-3">
                                    <i class="fas fa-mouse-pointer"></i>
                                </div>
                                <h5>Button Resize</h5>
                                <p class="text-muted small">Klik gambar → pilih ukuran</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="display-6 text-warning mb-3">
                                    <i class="fas fa-align-center"></i>
                                </div>
                                <h5>Style Options</h5>
                                <p class="text-muted small">Alignment & wrapping</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CKEditor 5 Superset Build -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/superbuild/ckeditor.js"></script>
    <script>
        let editorInstance;

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

        // Initialize CKEditor 5 Superset with all features
        CKEDITOR.ClassicEditor
            .create(document.querySelector('#content'), {
                extraPlugins: [CustomUploadAdapterPlugin],
                licenseKey: '',
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                placeholder: 'Upload gambar dan test fitur resize!',
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                htmlEmbed: {
                    showPreviews: true
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                removePlugins: [
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    'MathType'
                ],
                image: {
                    resizeUnit: 'px',
                    resizeOptions: [
                        {
                            name: 'resizeImage:original',
                            value: null,
                            icon: 'original'
                        },
                        {
                            name: 'resizeImage:25',
                            value: '25',
                            icon: 'small'
                        },
                        {
                            name: 'resizeImage:50',
                            value: '50',
                            icon: 'medium'
                        },
                        {
                            name: 'resizeImage:75',
                            value: '75',
                            icon: 'large'
                        }
                    ],
                    toolbar: [
                        'imageStyle:inline',
                        'imageStyle:wrapText',
                        'imageStyle:breakText',
                        '|',
                        'toggleImageCaption',
                        '|',
                        'imageTextAlternative',
                        '|',
                        'resizeImage:25',
                        'resizeImage:50',
                        'resizeImage:75',
                        'resizeImage:original'
                    ]
                }
            })
            .then(editor => {
                console.log('CKEditor 5 Superset initialized with Image Resize!');
                editorInstance = editor;
                window.editor = editor;

                // Add event listeners for image resize
                editor.model.document.on('change:data', () => {
                    console.log('Editor content changed');
                });

                // Image resize event
                editor.editing.view.document.on('imageResize', (evt, data) => {
                    console.log('Image resized:', data);
                    showNotification('Gambar berhasil di-resize!', 'success');
                });

                showNotification('Editor siap! Upload gambar dan coba fitur resize.', 'info');
            })
            .catch(error => {
                console.error('Error initializing editor:', error);
                showNotification('Error: ' + error.message, 'error');
            });

        // Helper functions
        function getEditorData() {
            if (editorInstance) {
                const data = editorInstance.getData();
                console.log('Editor data:', data);

                // Show in modal or new window
                const newWindow = window.open('', '_blank', 'width=800,height=600');
                newWindow.document.write(`
                    <html>
                        <head>
                            <title>Editor HTML Output</title>
                            <style>
                                body { font-family: monospace; padding: 20px; }
                                pre { background: #f5f5f5; padding: 20px; border-radius: 5px; overflow-x: auto; }
                            </style>
                        </head>
                        <body>
                            <h2>HTML Output:</h2>
                            <pre>${data.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</pre>
                            <h2>Preview:</h2>
                            <div style="border: 1px solid #ccc; padding: 20px; margin-top: 20px;">
                                ${data}
                            </div>
                        </body>
                    </html>
                `);
                newWindow.document.close();
            }
        }

        function addSampleImage() {
            if (editorInstance) {
                const sampleImageHtml = `
                <p>Sample image dengan berbagai ukuran:</p>
                <figure class="image image_resized" style="width: 25%;">
                    <img src="https://via.placeholder.com/800x400/4CAF50/white?text=Sample+Image+25%" alt="Sample 25%">
                    <figcaption>Gambar 25% - ini adalah caption</figcaption>
                </figure>
                <p>Teks di samping gambar yang kecil.</p>
                <figure class="image image_resized" style="width: 50%;">
                    <img src="https://via.placeholder.com/800x400/2196F3/white?text=Sample+Image+50%" alt="Sample 50%">
                    <figcaption>Gambar 50% - ukuran sedang</figcaption>
                </figure>
                <p>Teks di samping gambar yang sedang.</p>
                <figure class="image image_resized" style="width: 75%;">
                    <img src="https://via.placeholder.com/800x400/FF9800/white?text=Sample+Image+75%" alt="Sample 75%">
                    <figcaption>Gambar 75% - ukuran besar</figcaption>
                </figure>
                <p>Teks di bawah gambar yang besar.</p>
                `;

                editorInstance.setData(editorInstance.getData() + sampleImageHtml);
                showNotification('Sample images ditambahkan! Klik pada gambar untuk resize.', 'success');
            }
        }

        function clearEditor() {
            if (editorInstance) {
                editorInstance.setData('<p>Editor dikosongkan. Upload gambar baru untuk test resize!</p>');
                showNotification('Editor cleared!', 'info');
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
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                z-index: 10000;
                max-width: 300px;
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

            .ck-editor__editable {
                min-height: 500px;
            }

            /* Custom image resize styling */
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
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            .ck-content .image-inline {
                display: inline-block;
                align-items: flex-start;
                max-width: 100%;
                margin-left: 0;
                margin-right: 0;
            }

            .ck-content .image-style-wrap-text {
                float: right;
                margin: 0 0 1em 1em;
            }

            .ck-content .image-style-break-text {
                clear: both;
                display: block;
                margin: 1em auto;
            }

            /* Resize handles */
            .ck-widget.image > .ck-widget__resizer {
                display: block;
            }

            .ck-widget__resizer__handle {
                background: #007cff;
                border: 1px solid #fff;
                width: 8px;
                height: 8px;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
