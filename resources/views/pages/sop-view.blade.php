<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sop->nama_dokumen }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.11.174/build/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@3.11.174/build/pdf.worker.min.js';
    </script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100vh; width: 100vw; overflow: hidden; background: #222; }
        .pdf-wrapper { display: flex; flex-direction: column; height: 100vh; width: 100vw; }
        .pdf-toolbar { background: #333; color: #fff; padding: 8px 15px; display: flex; align-items: center; gap: 15px; flex-shrink: 0; }
        .pdf-toolbar button { background: #555; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
        .pdf-toolbar button:hover { background: #666; }
        .pdf-toolbar button:disabled { opacity: 0.5; cursor: not-allowed; }
        .pdf-container { flex: 1; overflow: auto; display: flex; flex-direction: column; align-items: center; padding: 10px; background: #444; }
        .pdf-page { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.3); margin-bottom: 10px; }
        .pdf-loading, .pdf-error { color: #fff; font-size: 18px; text-align: center; padding: 40px; }
        .pdf-error { color: #ff6b6b; }
    </style>
</head>
<body>
    <div class="pdf-wrapper">
        <div class="pdf-toolbar">
            <button id="btnPrev" onclick="prevPage()"><i class="bi bi-chevron-left"></i> Sebelumnya</button>
            <span>Halaman <strong id="pageNum">1</strong> dari <strong id="pageCount">-</strong></span>
            <button id="btnNext" onclick="nextPage()">Selanjutnya <i class="bi bi-chevron-right"></i></button>
        </div>
        <div class="pdf-container" id="pdfContainer"><div class="pdf-loading">Memuat dokumen...</div></div>
    </div>
    <script>
        var pdfUrl = "{{ $pdfUrl }}";
        var pdfDoc = null, pageNum = 1, pageRendering = false, pageNumPending = null, scale = 1.5;
        
        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
            pdfDoc = pdf;
            document.getElementById('pageCount').textContent = pdf.numPages;
            if (pdf.numPages === 1) {
                document.getElementById('btnPrev').disabled = true;
                document.getElementById('btnNext').disabled = true;
            }
            renderPage(pageNum);
        }).catch(function(error) {
            document.querySelector('.pdf-loading').outerHTML = '<div class="pdf-error">Gagal memuat PDF: ' + error.message + '</div>';
        });
        
        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
                var viewport = page.getViewport({ scale: scale });
                var canvas = document.createElement('canvas');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                canvas.className = 'pdf-page';
                document.getElementById('pdfContainer').innerHTML = '';
                document.getElementById('pdfContainer').appendChild(canvas);
                document.getElementById('pageNum').textContent = num;
                page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport }).promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) { renderPage(pageNumPending); pageNumPending = null; }
                });
            });
            document.getElementById('btnPrev').disabled = (num <= 1);
            document.getElementById('btnNext').disabled = (num >= pdfDoc.numPages);
        }
        
        function prevPage() { if (pageNum > 1) { pageNum--; queueRenderPage(pageNum); } }
        function nextPage() { if (pageNum < pdfDoc.numPages) { pageNum++; queueRenderPage(pageNum); } }
        function queueRenderPage(num) { pageRendering ? pageNumPending = num : renderPage(num); }
        document.addEventListener('keydown', function(e) { if (e.key === 'ArrowLeft') prevPage(); if (e.key === 'ArrowRight') nextPage(); });
    </script>
</body>
</html>