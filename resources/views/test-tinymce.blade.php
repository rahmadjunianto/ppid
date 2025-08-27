<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TinyMCE Test</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>TinyMCE Test Page</h1>
        <div class="alert alert-info">
            <strong>Test Page:</strong> Halaman ini untuk test apakah TinyMCE dapat di-load dengan benar.
        </div>

        <form>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Test Title">
            </div>

            <div class="form-group">
                <label for="content">Content (Rich Text Editor):</label>
                <textarea id="content" name="content">
                    <h2>Test Heading</h2>
                    <p>This is a test paragraph with <strong>bold text</strong> and <em>italic text</em>.</p>
                    <ul>
                        <li>List item 1</li>
                        <li>List item 2</li>
                        <li>List item 3</li>
                    </ul>
                    <p>This editor should show TinyMCE interface if everything is working correctly.</p>
                </textarea>
            </div>

            <div class="status">
                <strong>Status:</strong> <span id="editor-status">Loading...</span>
            </div>
        </form>
    </div>

    <!-- TinyMCE CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing TinyMCE...');

            // Update status
            document.getElementById('editor-status').textContent = 'Initializing TinyMCE...';

            tinymce.init({
                selector: '#content',
                height: 400,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | image media | table | code fullscreen preview',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px; line-height:1.6; margin: 1rem; }',
                setup: function (editor) {
                    editor.on('init', function () {
                        console.log('TinyMCE initialized successfully!');
                        document.getElementById('editor-status').textContent = 'TinyMCE loaded successfully! ✅';
                        document.getElementById('editor-status').style.color = 'green';
                    });

                    editor.on('change', function () {
                        console.log('Content changed');
                        editor.save();
                    });
                },
                init_instance_callback: function (editor) {
                    console.log('Editor instance callback:', editor.id);
                },
                branding: false,
                promotion: false
            }).then(function(editors) {
                console.log('TinyMCE init completed, editors:', editors);
            }).catch(function(error) {
                console.error('TinyMCE init failed:', error);
                document.getElementById('editor-status').textContent = 'TinyMCE failed to load: ' + error.message;
                document.getElementById('editor-status').style.color = 'red';
            });
        });
    </script>
</body>
</html>
