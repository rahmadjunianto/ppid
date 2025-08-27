<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Debug Image Upload Route - PPID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h1 class="text-primary mb-3">
                        <i class="fas fa-bug me-3"></i>
                        Debug Image Upload Route
                    </h1>
                    <p class="text-muted">Diagnostic tool untuk troubleshoot masalah upload gambar</p>
                </div>

                <!-- Route Information -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-route me-2"></i>Route Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Expected Routes:</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Route 1:</strong> <code>{{ route('admin.pages.upload-image') }}</code>
                                        <br><small class="text-muted">POST /admin/pages/upload-image</small>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Route 2:</strong> <code>{{ route('admin.pages.upload.image') }}</code>
                                        <br><small class="text-muted">POST /admin/pages/upload/image</small>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Server Information:</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>APP_URL:</strong> <code>{{ config('app.url') }}</code>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Current URL:</strong> <code>{{ url()->current() }}</code>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>CSRF Token:</strong> <code>{{ csrf_token() }}</code>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Test Upload Form -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Test Image Upload</h5>
                    </div>
                    <div class="card-body">
                        <form id="testUploadForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="testImage" class="form-label">Select Image to Test</label>
                                <input type="file" class="form-control" id="testImage" name="upload" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="uploadRoute" class="form-label">Select Upload Route</label>
                                <select class="form-control" id="uploadRoute">
                                    <option value="{{ route('admin.pages.upload-image') }}">Route 1: upload-image</option>
                                    <option value="{{ route('admin.pages.upload.image') }}">Route 2: upload.image</option>
                                    <option value="" id="protocolAwareRoute">Route 3: Protocol-aware upload.image</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="testUpload()">
                                <i class="fas fa-test me-2"></i>Test Upload
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Debug Results -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-terminal me-2"></i>Debug Results</h5>
                    </div>
                    <div class="card-body">
                        <div id="debugResults">
                            <p class="text-muted">Click "Test Upload" to see debug information...</p>
                        </div>
                    </div>
                </div>

                <!-- AJAX CKEditor Test -->
                <div class="card mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>CKEditor AJAX Test</h5>
                    </div>
                    <div class="card-body">
                        <div id="ajaxTestResults">
                            <button type="button" class="btn btn-warning" onclick="testAjaxUpload()">
                                <i class="fas fa-wifi me-2"></i>Test AJAX Upload (CKEditor Style)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addDebugLog(message, type = 'info') {
            const debugResults = document.getElementById('debugResults');
            const timestamp = new Date().toLocaleTimeString();
            const colors = {
                info: 'text-info',
                success: 'text-success',
                error: 'text-danger',
                warning: 'text-warning'
            };

            debugResults.innerHTML += `
                <div class="mb-2">
                    <span class="text-muted">[${timestamp}]</span>
                    <span class="${colors[type]}">${message}</span>
                </div>
            `;
            debugResults.scrollTop = debugResults.scrollHeight;
        }

        function testUpload() {
            const form = document.getElementById('testUploadForm');
            const fileInput = document.getElementById('testImage');
            const routeSelect = document.getElementById('uploadRoute');

            if (!fileInput.files[0]) {
                addDebugLog('Please select a file first!', 'error');
                return;
            }

            const file = fileInput.files[0];
            const uploadUrl = routeSelect.value;

            addDebugLog(`Starting upload test...`, 'info');
            addDebugLog(`File: ${file.name} (${file.size} bytes)`, 'info');
            addDebugLog(`Upload URL: ${uploadUrl}`, 'info');

            const formData = new FormData();
            formData.append('upload', file);
            formData.append('_token', '{{ csrf_token() }}');

            fetch(uploadUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                addDebugLog(`Response status: ${response.status} ${response.statusText}`,
                           response.ok ? 'success' : 'error');
                return response.json().catch(() => response.text());
            })
            .then(data => {
                if (typeof data === 'string') {
                    addDebugLog(`Response (text): ${data.substring(0, 500)}...`, 'warning');
                } else {
                    addDebugLog(`Response (JSON): ${JSON.stringify(data, null, 2)}`, 'success');
                    if (data.url) {
                        addDebugLog(`✅ Upload successful! Image URL: ${data.url}`, 'success');
                    }
                }
            })
            .catch(error => {
                addDebugLog(`❌ Upload failed: ${error.message}`, 'error');
                console.error('Upload error:', error);
            });
        }

        function testAjaxUpload() {
            const ajaxResults = document.getElementById('ajaxTestResults');

            // Create a test image blob
            const canvas = document.createElement('canvas');
            canvas.width = 100;
            canvas.height = 100;
            const ctx = canvas.getContext('2d');
            ctx.fillStyle = '#4CAF50';
            ctx.fillRect(0, 0, 100, 100);
            ctx.fillStyle = 'white';
            ctx.font = '16px Arial';
            ctx.fillText('TEST', 30, 55);

            canvas.toBlob(function(blob) {
                const testFile = new File([blob], 'test-image.png', { type: 'image/png' });

                addDebugLog('Testing AJAX upload with generated test image...', 'info');

                // Test both routes
                const routes = [
                    '{{ route("admin.pages.upload-image") }}',
                    '{{ route("admin.pages.upload.image") }}',
                    window.location.protocol + '//' + window.location.host + '{{ str_replace(url("/"), "", route("admin.pages.upload.image")) }}'
                ];

                routes.forEach((route, index) => {
                    setTimeout(() => {
                        const formData = new FormData();
                        formData.append('upload', testFile);

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', route, true);
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        xhr.responseType = 'json';

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                addDebugLog(`✅ Route ${index + 1} success: ${JSON.stringify(xhr.response)}`, 'success');
                            } else {
                                addDebugLog(`❌ Route ${index + 1} failed: ${xhr.status} ${xhr.statusText}`, 'error');
                            }
                        };

                        xhr.onerror = function() {
                            addDebugLog(`❌ Route ${index + 1} network error`, 'error');
                        };

                        xhr.send(formData);
                        addDebugLog(`Testing route ${index + 1}: ${route}`, 'info');
                    }, index * 1000);
                });
            }, 'image/png');
        }

        // Auto-run basic connectivity tests
        document.addEventListener('DOMContentLoaded', function() {
            // Set up protocol-aware route option
            const protocolAwareOption = document.getElementById('protocolAwareRoute');
            const uploadPath = '{{ str_replace(url("/"), "", route("admin.pages.upload.image")) }}';
            const protocolAwareUrl = window.location.protocol + '//' + window.location.host + uploadPath;
            protocolAwareOption.value = protocolAwareUrl;
            protocolAwareOption.textContent = `Route 3: Protocol-aware (${window.location.protocol}) upload.image`;

            addDebugLog('🚀 Debug tool loaded successfully', 'success');
            addDebugLog(`Current domain: ${window.location.hostname}`, 'info');
            addDebugLog(`Protocol: ${window.location.protocol}`, 'info');
            addDebugLog(`Protocol-aware URL: ${protocolAwareUrl}`, 'info');

            // Test route availability
            const routes = [
                '{{ route("admin.pages.upload-image") }}',
                '{{ route("admin.pages.upload.image") }}',
                protocolAwareUrl
            ];

            routes.forEach((route, index) => {
                fetch(route, { method: 'HEAD' })
                    .then(response => {
                        addDebugLog(`Route ${index + 1} availability: ${response.status}`,
                                   response.status === 405 ? 'success' : 'warning');
                    })
                    .catch(error => {
                        addDebugLog(`Route ${index + 1} not reachable: ${error.message}`, 'error');
                    });
            });
        });
    </script>
</body>
</html>
