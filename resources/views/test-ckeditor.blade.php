<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CKEditor 5 Test</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 50px; 
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }
        .status {
            margin: 20px 0;
            padding: 10px;
            background: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        .ck-editor__editable {
            min-height: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CKEditor 5 Test Page</h1>
        <div class="alert alert-info">
            <strong>Test Page:</strong> Halaman ini untuk test apakah CKEditor 5 dapat di-load dengan benar.
        </div>

        <form>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Test Title">
            </div>

            <div class="form-group">
                <label for="content">Content (Rich Text Editor):</label>
                <div id="content">
                    <h2>Test Heading</h2>
                    <p>This is a test paragraph with <strong>bold text</strong> and <em>italic text</em>.</p>
                    <ul>
                        <li>List item 1</li>
                        <li>List item 2</li>
                        <li>List item 3</li>
                    </ul>
                    <p>This editor should show CKEditor 5 interface if everything is working correctly.</p>
                </div>
                <textarea id="content-hidden" name="content" style="display:none;"></textarea>
            </div>

            <div class="status">
                <strong>Status:</strong> <span id="editor-status">Loading...</span>
            </div>
        </form>
    </div>

    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing CKEditor 5...');
            
            // Update status
            document.getElementById('editor-status').textContent = 'Initializing CKEditor 5...';
            
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
                            'imageUpload',
                            'blockQuote',
                            'insertTable',
                            'mediaEmbed',
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
                            'imageStyle:side'
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
                    document.getElementById('editor-status').textContent = 'CKEditor 5 loaded successfully! ✅';
                    document.getElementById('editor-status').style.color = 'green';
                    
                    // Sync content with hidden textarea
                    editor.model.document.on('change:data', () => {
                        document.getElementById('content-hidden').value = editor.getData();
                    });
                    
                    // Set initial content
                    document.getElementById('content-hidden').value = editor.getData();
                })
                .catch(error => {
                    console.error('CKEditor 5 initialization failed:', error);
                    document.getElementById('editor-status').textContent = 'CKEditor 5 failed to load: ' + error.message;
                    document.getElementById('editor-status').style.color = 'red';
                });
        });
    </script>
</body>
</html>
