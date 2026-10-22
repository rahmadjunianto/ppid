@extends('layouts.app')
@section('title', 'SOP Layanan Informasi Publik')
@section('meta_description', 'Standar operasional prosedur pelayanan informasi PPID.')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="#">Informasi Publik</a></li>
    <li class="breadcrumb-item active">SOP</li>
@endsection

@section('content')
<div class="container my-5">
    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon">
                <i class="bi bi-file-earmark-check"></i>
            </div>
            <div>
                <h1 class="display-5 fw-bold">SOP Layanan Informasi Publik</h1>
                <p class="lead text-muted mb-0">
                    Standar operasional prosedur pelayanan informasi PPID dan unit kerja lain di lingkungan Kankemenag Kab Nganjuk
                </p>
            </div>
        </div>
    </div>
    {{-- Category Tabs --}}
    <div class="sop-tabs mb-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ $tab == 'ppid' ? 'active' : '' }}" href="{{ url('/sop?tab=ppid') }}">
                    <i class="bi bi-building me-2"></i>SOP PPID
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab == 'subbag_tu' ? 'active' : '' }}" href="{{ url('/sop?tab=subbag_tu') }}">
                    <i class="bi bi-folder me-2"></i>Sub Bag TU
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab == 'bimas' ? 'active' : '' }}" href="{{ url('/sop?tab=bimas') }}">
                    <i class="bi bi-people me-2"></i>Bimas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab == 'pais' ? 'active' : '' }}" href="{{ url('/sop?tab=pais') }}">
                    <i class="bi bi-book me-2"></i>Pais
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab == 'pendma' ? 'active' : '' }}" href="{{ url('/sop?tab=pendma') }}">
                    <i class="bi bi-mortarboard me-2"></i>Pendma
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab == 'pd_pontren' ? 'active' : '' }}" href="{{ url('/sop?tab=pd_pontren') }}">
                    <i class="bi bi-grid me-2"></i>PD Pontren
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab == 'penzawa' ? 'active' : '' }}" href="{{ url('/sop?tab=penzawa') }}">
                    <i class="bi bi-heart me-2"></i>Penyelenggara Zakat Wakaf
                </a>
            </li>
        </ul>
    </div>

    {{-- Search & Filter Row --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <form action="{{ url('/sop') }}" method="GET" class="d-flex gap-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="input-group flex-grow-1">
                    <input type="text" name="search" class="form-control" placeholder="Cari dokumen SOP..." value="{{ $search }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                        <a href="{{ url('/sop?tab=' . $tab) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
        <div class="col-md-4 text-md-end mt-2 mt-md-0">
            <span class="text-muted">
                <i class="bi bi-file-text me-1"></i>{{ $sops->count() }} dokumen
            </span>
        </div>
    </div>
    {{-- SOP Table or Empty State --}}
    @if($sops->count() > 0)
        <div class="sop-table-container">
            <table class="table sop-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px">No</th>
                        <th>Nama Dokumen</th>
                        <th class="text-center" style="width: 100px">Tahun</th>
                        <th class="text-center" style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sops as $index => $sop)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-file-earmark-pdf text-danger fs-5"></i>
                                    <div>
                                        <div class="fw-semibold">{{ $sop->nama_dokumen }}</div>
                                        @if($sop->nomor)
                                            <small class="text-muted">No. {{ $sop->nomor }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($sop->tahun)
                                    <span class="badge bg-light text-dark">{{ $sop->tahun }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf-id="{{ $sop->id }}" data-doc-name="{{ $sop->nama_dokumen }}">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </button>
                                    <a href="{{ route('sop.download', $sop) }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-download me-1"></i>Unduh
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-3 shadow-sm">
            <i class="bi bi-folder2-open text-muted fs-1"></i>
            <h5 class="text-muted mt-3">Belum ada dokumen SOP</h5>
            <p class="text-muted">Dokumen SOP untuk kategori ini belum tersedia.</p>
        </div>
    @endif

    {{-- Show All Button --}}
    @if($search)
        <div class="mt-4 text-center">
            <a href="{{ url('/sop?tab=' . $tab) }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-2"></i>Tampilkan Semua
            </a>
        </div>
    @endif
</div>

{{-- PDF Popup Modal --}}
<div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
            <div class="pdf-modal-header" style="background: #1e5631; color: #fff; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center;">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-pdf me-2"></i>
                    <span id="pdfDocName">Dokumen SOP</span>
                </h5>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <iframe id="pdfIframe" src="" style="width: 100%; height: 70vh; min-height: 400px; border: none; display: block;"></iframe>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    :root {
        --primary: #1e5631;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 25px;
        border-radius: 12px;
        border-left: 4px solid var(--primary);
    }

    .header-icon {
        width: 55px;
        height: 55px;
        background: var(--primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 24px;
        flex-shrink: 0;
    }

    .display-5 {
        color: var(--primary);
        font-size: 1.6rem;
        margin-bottom: 0.25rem;
    }

    /* Tabs Styling */
    .sop-tabs .nav-tabs {
        border: none;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 4px;
        flex-wrap: wrap;
        gap: 4px;
    }

    .sop-tabs .nav-link {
        border: none;
        border-radius: 6px;
        padding: 10px 20px;
        color: #6c757d;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .sop-tabs .nav-link:hover {
        color: var(--primary);
        background: rgba(30, 86, 49, 0.1);
    }

    .sop-tabs .nav-link.active {
        background: var(--primary) !important;
        color: #fff !important;
    }

    /* Table Styling */
    .sop-table-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .sop-table {
        margin-bottom: 0;
    }

    .sop-table thead th {
        background: var(--primary);
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 14px;
        font-size: 0.9rem;
    }

    .sop-table tbody tr {
        transition: background 0.2s ease;
    }

    .sop-table tbody tr:hover {
        background: rgba(30, 86, 49, 0.05);
    }

    .sop-table tbody td {
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
        padding: 12px 14px;
    }

    .sop-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Button Styling */
    .btn-success {
        background: var(--primary);
        border-color: var(--primary);
        transition: all 0.2s ease;
    }

    .btn-success:hover {
        background: #2d8f4e;
        border-color: #2d8f4e;
        color: #fff;
    }

    .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background: #2d8f4e;
        border-color: #2d8f4e;
    }

    .btn-outline-primary {
        color: var(--primary);
        border-color: var(--primary);
        transition: all 0.2s ease;
    }

    .btn-outline-primary:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sop-tabs .nav-tabs {
            flex-direction: column;
        }

        .sop-tabs .nav-link {
            width: 100%;
            text-align: center;
        }

        .display-5 {
            font-size: 1.4rem;
        }
    }

    /* PDF Modal Fullscreen */
    #pdfModal {
        padding: 0 !important;
    }
    
    #pdfModal .modal-fullscreen {
        width: 100vw !important;
        height: 100vh !important;
        max-width: 100vw !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    #pdfModal .modal-dialog {
        width: 100vw !important;
        height: 100vh !important;
        max-width: 100vw !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    #pdfModal .modal-content {
        width: 100vw !important;
        height: 100vh !important;
        border: none !important;
        border-radius: 0 !important;
    }
    
    #pdfModal .pdf-modal-header {
        flex-shrink: 0;
    }
</style>
@endsection

@push('scripts')
<script>
// Set iframe src when modal is about to be shown
document.addEventListener('DOMContentLoaded', function() {
    var pdfModal = document.getElementById('pdfModal');
    var pdfIframe = document.getElementById('pdfIframe');
    var pdfDocName = document.getElementById('pdfDocName');
    
    pdfModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var pdfId = button.getAttribute('data-pdf-id');
        var docName = button.getAttribute('data-doc-name') || 'Dokumen SOP';
        
        // Set document name in header
        pdfDocName.textContent = docName;
        
        // Set iframe src
        if (pdfId) {
            pdfIframe.src = '/sop/view/' + pdfId;
        }
    });
    
    // Clear iframe when modal is closed
    pdfModal.addEventListener('hidden.bs.modal', function() {
        pdfIframe.src = '';
    });
});
</script>
@endpush
