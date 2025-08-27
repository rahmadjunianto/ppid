@extends('admin.layouts.app')

@section('title', 'Test CKEditor')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Test CKEditor 5</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">CKEditor 5 Test</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="content">Content Editor</label>
                        <div id="content">
                            <h2>Test Heading</h2>
                            <p>This is a <strong>test</strong> content for CKEditor 5.</p>
                            <ul>
                                <li>Item 1</li>
                                <li>Item 2</li>
                            </ul>
                        </div>
                    </div>

                    <button type="button" onclick="getContent()" class="btn btn-primary">Get Content</button>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing CKEditor 5...');

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
            window.testEditor = editor;
        })
        .catch(error => {
            console.error('CKEditor 5 initialization failed:', error);
        });
});

function getContent() {
    if (window.testEditor) {
        alert('Content: ' + window.testEditor.getData());
    } else {
        alert('Editor not initialized');
    }
}
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
