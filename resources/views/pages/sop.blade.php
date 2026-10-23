@extends('layouts.app')
@section('title', 'SOP Layanan Informasi Publik')
@section('meta_description', 'Standar operasional prosedur pelayanan informasi PPID.')
@section('content')
<div class="container my-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-page">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/pustaka-dokumen') }}">Standar Layanan</a></li>
            <li class="breadcrumb-item active" aria-current="page">SOP</li>
        </ol>
    </nav>

    {{-- Page Header & Search --}}
    <div class="row mb-4 align-items-center">
        <div class="col-lg-8">
            <h4 class="fw-bold text-success mb-1"><i class="bi bi-file-earmark-check me-2"></i>SOP Layanan Informasi Publik</h4>
            <p class="text-muted mb-0 small">Standar operasional prosedur pelayanan informasi PPID dan unit kerja lain di lingkungan Kankemenag Kab Nganjuk</p>
        </div>
        <div class="col-lg-4">
            <form method="GET" action="{{ url('/sop') }}">
                <input type="hidden" name="tab" value="{{ $tab }}">
                @if($grup)<input type="hidden" name="grup" value="{{ $grup }}">@endif
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari dokumen SOP..." value="{{ $search ?? '' }}">
                    <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    {{-- Filter Buttons --}}
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <a href="{{ url('/sop?tab=ppid') }}" class="btn btn-sm {{ $tab == 'ppid' ? 'text-white' : 'btn-outline-success' }}" style="{{ $tab == 'ppid' ? 'background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;' : '' }}">
                <i class="bi bi-building me-1"></i> SOP PPID
            </a>
            <a href="{{ url('/sop?tab=unit_kerja') }}" class="btn btn-sm {{ $tab == 'unit_kerja' ? 'text-white' : 'btn-outline-success' }}" style="{{ $tab == 'unit_kerja' ? 'background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;' : '' }}">
                <i class="bi bi-diagram-3 me-1"></i> SOP Unit Kerja Lain
            </a>
            @if($tab == 'unit_kerja')
                <form method="GET" action="{{ url('/sop') }}" class="ms-auto">
                    <input type="hidden" name="tab" value="unit_kerja">
                    @if($search)<input type="hidden" name="search" value="{{ $search }}">@endif
                    <select name="grup" class="form-select form-select-sm" style="max-width: 260px;" onchange="this.form.submit()">
                        <option value="">Semua Unit Kerja</option>
                        @foreach($unitKerjaList as $unit)
                            <option value="{{ $unit }}" {{ $grup == $unit ? 'selected' : '' }}>
                                {{ $grupOptions[$unit] }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif
        </div>
    </div>

    {{-- SOP Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Dokumen</th>
                            @if($tab == 'unit_kerja')
                                <th width="160">Unit Kerja</th>
                            @endif
                            <th width="80">Tahun</th>
                            <th width="90" class="text-center">Dilihat</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sops as $index => $sop)
                            <tr>
                                <td class="text-center text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $sop->nama_dokumen }}</strong>
                                    @if($sop->nomor)
                                        <br><small class="text-muted">No. {{ $sop->nomor }}</small>
                                    @endif
                                </td>
                                @if($tab == 'unit_kerja')
                                    <td>
                                        <span class="badge" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white; font-size: 0.75rem;">{{ $grupOptions[$sop->grup] ?? $sop->grup }}</span>
                                    </td>
                                @endif
                                <td class="text-muted">{{ $sop->tahun ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border"><i class="fas fa-eye me-1"></i>{{ $sop->view_count ?? 0 }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-success btn-sm" title="Lihat" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf-id="{{ $sop->id }}" data-doc-name="{{ $sop->nama_dokumen }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('sop.download', $sop) }}" class="btn btn-success btn-sm" title="Unduh" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $tab == 'unit_kerja' ? 6 : 5 }}" class="text-center py-5">
                                    <i class="bi bi-folder2-open text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2 mb-0">Tidak ada dokumen ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <p class="text-muted small text-center mt-3 mb-0">
        Menampilkan {{ $sops->count() }} dokumen
    </p>
</div>

{{-- PDF Popup Modal --}}
<div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
            <div class="pdf-modal-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: #fff; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center;">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-pdf me-2"></i>
                    <span id="pdfDocName">Dokumen SOP</span>
                </h5>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <iframe id="pdfIframe" src="" style="width: 100%; height: 70vh; min-height: 400px; border: none; display: block;"></iframe>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* PDF Modal */
    #pdfModal .pdf-modal-header {
        flex-shrink: 0;
    }

    #pdfModal .modal-content {
        overflow: hidden;
    }

    @media (max-width: 768px) {
        #pdfModal .modal-dialog {
            margin: 0;
        }

        #pdfIframe {
            height: 80vh !important;
        }
    }
</style>
@endpush

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
