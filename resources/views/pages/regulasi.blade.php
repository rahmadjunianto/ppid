@extends('layouts.app')

@section('title', 'Regulasi & Peraturan')
@section('meta_description', 'Daftar peraturan perundang-undangan, keputusan, dan edaran terkait keterbukaan informasi publik dan penyelenggaraan kantor.')

@push('styles')
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

    /* Tabs */
    .regulasi-tabs .nav-tabs {
        border-bottom: 2px solid #dee2e6;
        gap: 4px;
    }

    .regulasi-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 10px 18px;
        border-radius: 8px 8px 0 0;
        transition: all 0.2s ease;
    }

    .regulasi-tabs .nav-link:hover {
        color: var(--primary);
        background: rgba(30, 86, 49, 0.05);
    }

    .regulasi-tabs .nav-link.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
        font-weight: 600;
    }

    .tab-count {
        background: #e9ecef;
        color: #495057;
        border-radius: 10px;
        padding: 1px 8px;
        font-size: 0.75rem;
        margin-left: 6px;
    }

    .regulasi-tabs .nav-link.active .tab-count {
        background: var(--primary);
        color: #fff;
    }

    /* Table */
    .regulasi-table-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .regulasi-table {
        margin-bottom: 0;
    }

    .regulasi-table thead th {
        background: var(--primary);
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px;
        border: none;
        white-space: nowrap;
    }

    .regulasi-table tbody tr {
        transition: background 0.2s ease;
    }

    .regulasi-table tbody tr:hover {
        background: rgba(30, 86, 49, 0.05);
    }

    .regulasi-table tbody td {
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
        padding: 12px 14px;
    }

    .regulasi-table tbody tr:last-child td {
        border-bottom: none;
    }

    .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background: #2d8f4e;
        border-color: #2d8f4e;
    }

    .btn-outline-primary {
        color: var(--primary);
        border-color: var(--primary);
    }

    .btn-outline-primary:hover {
        background: var(--primary);
        color: #fff;
    }

    .btn-success {
        background: var(--primary);
        border-color: var(--primary);
    }

    .btn-success:hover {
        background: #2d8f4e;
        border-color: #2d8f4e;
        color: #fff;
    }

    @media (max-width: 768px) {
        .regulasi-tabs .nav-tabs {
            flex-direction: column;
        }

        .regulasi-tabs .nav-link {
            width: 100%;
            text-align: center;
        }

        .display-5 {
            font-size: 1.4rem;
        }
    }
</style>
@endpush


@section('content')
<div class="container my-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-page">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/pustaka-dokumen') }}">Informasi Publik</a></li>
            <li class="breadcrumb-item active" aria-current="page">Regulasi &amp; Peraturan</li>
        </ol>
    </nav>

    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon">
                <i class="bi bi-journal-bookmark"></i>
            </div>
            <div>
                <h1 class="display-5 fw-bold mb-1">Regulasi &amp; Peraturan</h1>
                <p class="lead text-muted mb-0">
                    Peraturan perundang-undangan, keputusan, dan edaran terkait keterbukaan informasi publik dan penyelenggaraan kantor.
                </p>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="regulasi-tabs mb-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'semua' ? 'active' : '' }}" href="{{ url('/regulasi?tab=semua') }}">
                    <i class="bi bi-collection me-2"></i>Semua Regulasi
                    <span class="tab-count">{{ $counts['semua'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'pusat' ? 'active' : '' }}" href="{{ url('/regulasi?tab=pusat') }}">
                    <i class="bi bi-building me-2"></i>Tingkat Pusat
                    <span class="tab-count">{{ $counts['pusat'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $tab === 'kankemenag' ? 'active' : '' }}" href="{{ url('/regulasi?tab=kankemenag') }}">
                    <i class="bi bi-diagram-3 me-2"></i>Tingkat Kankemenag
                    <span class="tab-count">{{ $counts['kankemenag'] }}</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Search & Filter Row --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <form action="{{ url('/regulasi') }}" method="GET" class="d-flex gap-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="input-group flex-grow-1">
                    <input type="text" name="search" class="form-control" placeholder="Cari regulasi..." value="{{ $search }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                        <a href="{{ url('/regulasi?tab=' . $tab) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
        <div class="col-md-4 text-md-end mt-2 mt-md-0">
            <span class="text-muted">
                <i class="bi bi-journal-text me-1"></i>{{ $regulasi->total() }} regulasi
            </span>
        </div>
    </div>



    {{-- Tabel Regulasi --}}
    @if($regulasi->count() > 0)
        <div class="regulasi-table-container">
            <div class="table-responsive">
                <table class="table regulasi-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px">No</th>
                            <th>Nama Regulasi</th>
                            <th class="text-center" style="width: 180px">Nomor</th>
                            <th class="text-center" style="width: 160px">Tingkat</th>
                            <th class="text-center" style="width: 130px">Unduh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($regulasi as $index => $item)
                            <tr>
                                <td class="text-center">{{ $regulasi->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-file-earmark-text text-primary fs-5"></i>
                                        <div>
                                            <div class="fw-semibold">{{ $item->nama_regulasi }}</div>
                                            @if($item->tahun)
                                                <small class="text-muted">Tahun {{ $item->tahun }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">
                                        {{ $item->nomor ?: '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($item->tingkat === 'pusat')
                                        <span class="badge bg-primary">Pusat</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Kankemenag</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        @if($item->link_type === 'file' && $item->file)
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf-id="{{ $item->id }}" data-doc-name="{{ $item->nama_regulasi }}">
                                                <i class="bi bi-eye me-1"></i>Lihat
                                            </button>
                                            <a href="{{ route('regulasi.download', $item->id) }}" class="btn btn-success btn-sm">
                                                <i class="bi bi-download me-1"></i>Unduh
                                            </a>
                                        @elseif($item->link_type === 'link' && $item->link_url)
                                            <a href="{{ route('regulasi.link', $item->id) }}" class="btn btn-success btn-sm" target="_blank">
                                                <i class="bi bi-download me-1"></i>Unduh
                                            </a>
                                        @else
                                            <span class="text-muted small">Tidak tersedia</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($regulasi->hasPages())
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $regulasi->firstItem() }} - {{ $regulasi->lastItem() }}
                    dari {{ $regulasi->total() }} regulasi
                </small>
                <div>
                    {{ $regulasi->links('custom-pagination') }}
                </div>
            </div>
            @endif
        </div>
    @else
        <div class="regulasi-table-container">
            <div class="text-center py-5 bg-white rounded-3 shadow-sm">
                <i class="bi bi-folder2-open text-muted fs-1"></i>
                <h5 class="text-muted mt-3">Belum ada regulasi</h5>
                <p class="text-muted">Dokumen regulasi untuk kategori ini belum tersedia.</p>
            </div>
        </div>
    @endif

    {{-- Tampilkan Semua --}}
    @if($search)
        <div class="mt-4 text-center">
            <a href="{{ url('/regulasi?tab=' . $tab) }}" class="btn btn-primary">
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
                    <span id="pdfDocName">Dokumen Regulasi</span>
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

@push('scripts')
<script>
// Set iframe src saat modal akan ditampilkan
document.addEventListener('DOMContentLoaded', function() {
    var pdfModal = document.getElementById('pdfModal');
    var pdfIframe = document.getElementById('pdfIframe');
    var pdfDocName = document.getElementById('pdfDocName');

    pdfModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var pdfId = button.getAttribute('data-pdf-id');
        var docName = button.getAttribute('data-doc-name') || 'Dokumen Regulasi';

        pdfDocName.textContent = docName;

        if (pdfId) {
            pdfIframe.src = '/regulasi/view/' + pdfId;
        }
    });

    pdfModal.addEventListener('hidden.bs.modal', function() {
        pdfIframe.src = '';
    });
});
</script>
@endpush

