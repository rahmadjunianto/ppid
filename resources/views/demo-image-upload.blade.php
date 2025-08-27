<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo CKEditor 5 dengan Upload Image</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }

        .page-title {
            color: #1e5631;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 3px solid #1e5631;
            padding-bottom: 15px;
        }

        .editor-container {
            margin: 30px 0;
        }

        .ck-editor__editable {
            min-height: 400px;
        }

        .demo-content {
            background: linear-gradient(135deg, #e7f3ff, #f0f9ff);
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border: 1px solid #b8daff;
        }

        .feature-list {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .feature-list h3 {
            color: #1e5631;
            margin-bottom: 15px;
        }

        .feature-list ul {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
        }

        .feature-list li:last-child {
            border-bottom: none;
        }

        .feature-list li strong {
            color: #1e5631;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title">🖼️ Demo CKEditor 5 dengan Upload Image</h1>

        <div class="demo-content">
            <h3 style="color: #1e5631; margin-bottom: 10px;">🎯 Fitur Upload Image Tersedia!</h3>
            <p style="color: #2c5282; margin: 0;">
                CKEditor 5 sekarang sudah dilengkapi dengan fitur upload image yang powerful.
                Anda dapat mengupload gambar langsung dari toolbar editor dan mengatur posisi serta ukurannya.
            </p>
        </div>

        <div class="editor-container">
            <div id="editor">
                <h2 style="color: #1e5631;">Contoh Konten dengan Gambar</h2>

                <p>Selamat datang di sistem PPID Kemenag yang telah dilengkapi dengan editor teks kaya (rich text editor) menggunakan CKEditor 5.</p>

                <h3>🖼️ Upload dan Kelola Gambar</h3>
                <p>Dengan fitur baru ini, Anda dapat:</p>
                <ul>
                    <li><strong>Upload gambar</strong> langsung dari komputer Anda</li>
                    <li><strong>Mengatur ukuran</strong> gambar (25%, 50%, 75%, original)</li>
                    <li><strong>Posisi gambar</strong> (inline, block, atau side)</li>
                    <li><strong>Menambahkan caption</strong> untuk keterangan gambar</li>
                    <li><strong>Alt text</strong> untuk accessibility</li>
                </ul>

                <figure class="image">
                    <img src="{{ asset('images/demo/sample.svg') }}" alt="Contoh gambar PPID Kemenag">
                    <figcaption>Contoh gambar dengan caption. Gambar ini menunjukkan bagaimana konten visual dapat memperkaya informasi PPID.</figcaption>
                </figure>

                <h3>📋 Informasi Publik yang Tersedia</h3>
                <table style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #1e5631, #2d8f47);">
                            <th style="border: 1px solid #ddd; padding: 12px; color: white;">Jenis Informasi</th>
                            <th style="border: 1px solid #ddd; padding: 12px; color: white;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">Profil PPID</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">✅ Tersedia</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">Daftar Informasi Publik</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">✅ Tersedia</td>
                        </tr>
                    </tbody>
                </table>

                <blockquote style="border-left: 4px solid #1e5631; padding-left: 16px; margin: 20px 0; font-style: italic; color: #4a5568;">
                    <p>Semua informasi dapat diakses sesuai dengan ketentuan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.</p>
                </blockquote>
            </div>
        </div>

        <div class="feature-list">
            <h3>🚀 Fitur CKEditor 5 yang Tersedia:</h3>
            <ul>
                <li><strong>📝 Rich Text Editing:</strong> Bold, italic, heading, lists</li>
                <li><strong>🖼️ Image Upload:</strong> Drag & drop atau click to upload</li>
                <li><strong>📊 Table Editor:</strong> Insert dan edit tabel dengan mudah</li>
                <li><strong>🔗 Link Manager:</strong> Tambahkan link internal/external</li>
                <li><strong>📋 Copy/Paste:</strong> Dari Word, Google Docs, dll</li>
                <li><strong>↩️ Undo/Redo:</strong> Batalkan atau ulangi perubahan</li>
                <li><strong>💻 Source Editing:</strong> Edit HTML langsung</li>
                <li><strong>📱 Responsive:</strong> Otomatis responsive di mobile</li>
            </ul>
        </div>
    </div>

    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
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
                if (!response || xhr.status !== 200) {
                    return reject(response && response.error && response.error.message ? response.error.message : genericErrorText);
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

    ClassicEditor
        .create(document.querySelector('#editor'), {
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
                    'insertTable',
                    'blockQuote',
                    '|',
                    'undo',
                    'redo',
                    'sourceEditing'
                ]
            },
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
                ]
            }
        })
        .then(editor => {
            console.log('CKEditor 5 with image upload ready!');
        })
        .catch(error => {
            console.error(error);
        });
    </script>
</body>
</html>
