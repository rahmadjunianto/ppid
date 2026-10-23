@extends('layouts.app')

@section('title', 'Regulasi & Peraturan')
@section('meta_description', 'Daftar peraturan perundang-undangan, keputusan, dan edaran terkait keterbukaan informasi publik dan penyelenggaraan kantor.')

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

    {{-- Page Header & Search --}}
    <div class="row mb-4 align-items-center">
        <div class="col-lg-8">
            <h4 class="fw-bold text-success mb-1"><i class="bi bi-journal-bookmark me-2"></i>Regulasi &amp; Peraturan</h4>
            <p class="text-muted mb-0 small">Peraturan perundang-undangan, keputusan, dan edaran terkait keterbukaan informasi publik dan penyelenggaraan kantor.</p>
        </div>
        <div class="col-lg-4">
            <form method="GET" action="{{ url('/regulasi') }}">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari regulasi..." value="{{ $search ?? '' }}">
                    <button class="btn btn-success" type="submit"><i class="fas fa-search"></i></button>
                    @if($search)
                        <a href="{{ url('/regulasi?tab=' . $tab) }}" class="btn btn-outline-secondary" title="Hapus pencarian"><i class="fas fa-times"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Filter Buttons --}}
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/regulasi?tab=semua') }}" class="btn btn-sm {{ $tab === 'semua' ? 'text-white' : 'btn-outline-success' }}" style="{{ $tab === 'semua' ? 'background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;' : '' }}">
                <i class="bi bi-collection me-1"></i> Semua Regulasi
                <span class="badge ms-1 {{ $tab === 'semua' ? 'bg-white text-success' : 'bg-light text-dark' }}">{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ url('/regulasi?tab=pusat') }}" class="btn btn-sm {{ $tab === 'pusat' ? 'text-white' : 'btn-outline-success' }}" style="{{ $tab === 'pusat' ? 'background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;' : '' }}">
                <i class="bi bi-building me-1"></i> Tingkat Pusat
                <span class="badge ms-1 {{ $tab === 'pusat' ? 'bg-white text-success' : 'bg-light text-dark' }}">{{ $counts['pusat'] }}</span>
            </a>
            <a href="{{ url('/regulasi?tab=kankemenag') }}" class="btn btn-sm {{ $tab === 'kankemenag' ? 'text-white' : 'btn-outline-success' }}" style="{{ $tab === 'kankemenag' ? 'background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;' : '' }}">
                <i class="bi bi-diagram-3 me-1"></i> Tingkat Kankemenag
                <span class="badge ms-1 {{ $tab === 'kankemenag' ? 'bg-white text-success' : 'bg-light text-dark' }}">{{ $counts['kankemenag'] }}</span>
            </a>
        </div>
    </div>

    {{-- Tabel Regulasi --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Regulasi</th>
                            <th width="160">Nomor</th>
                            <th width="140">Tingkat</th>
                            <th width="80">Tahun</th>
                            <th width="90" class="text-center">Dilihat</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($regulasi as $index => $item)
                            <tr>
                                <td class="text-center text-muted">{{ $regulasi->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $item->nama_regulasi }}</strong>
                                    @if($item->link_type === 'file' && $item->file)
                                        <span class="badge bg-secondary ms-2">{{ strtoupper(pathinfo($item->file, PATHINFO_EXTENSION)) }}</span>
                                    @endif
                                    @if($item->ukuran)
                                        <br><small class="text-muted">Ukuran: {{ $item->ukuran_formatted }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $item->nomor ?: '-' }}</span>
                                </td>
                                <td>
                                    <span class="badge" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white; font-size: 0.75rem;">{{ $item->tingkat_label }}</span>
                                </td>
                                <td class="text-muted">{{ $item->tahun ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border"><i class="fas fa-eye me-1"></i>{{ $item->view_count ?? 0 }}</span>
                                </td>
                                <td class="text-center">
                                    @if($item->link_type === 'file')
                                        @if($item->file_exists)
                                            <button type="button" class="btn btn-outline-success btn-sm" title="Lihat" data-bs-toggle="modal" data-bs-target="#pdfModal" data-pdf-id="{{ $item->id }}" data-doc-name="{{ $item->nama_regulasi }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('regulasi.download', $item->id) }}" class="btn btn-success btn-sm" title="Unduh" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted small">File tidak ada</span>
                                        @endif
                                    @else
                                        @if($item->link_url)
                                            <a href="{{ route('regulasi.link', $item->id) }}" target="_blank" class="btn btn-sm text-white" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;">
                                                <i class="fas fa-external-link-alt me-1"></i> Kunjungi
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-folder2-open text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2 mb-0">Tidak ada regulasi ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($regulasi->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $regulasi->links('custom-pagination') }}
        </div>
    @endif
    <p class="text-muted small text-center mt-3 mb-0">
        Menampilkan {{ $regulasi->count() }} dari {{ $regulasi->total() }} regulasi
    </p>
</div>



{{-- PDF Popup Modal --}}
<div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
            <div class="pdf-modal-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: #fff; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center;">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-pdf me-2"></i>
                    <span id="pdfDocName">Dokumen Regulasi</span>
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
// Set iframe src saat modal akan ditampilkan
document.addEventListener('DOMContentLoaded', function() {
    var pdfModal = document.getElementById('pdfModal');
    var pdfIframe = document.getElementById('pdfIframe');
    var pdfDocName = document.getElementById('pdfDocName');

    pdfModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var pdfId = button.getAttribute('data-pdf-id');
        var docName = button.getAttribute('data-doc-name') || 'Dokumen Regulasi';

        // Set nama dokumen pada header
        pdfDocName.textContent = docName;

        // Set iframe src
        if (pdfId) {
            pdfIframe.src = '/regulasi/view/' + pdfId;
        }
    });

    // Bersihkan iframe saat modal ditutup
    pdfModal.addEventListener('hidden.bs.modal', function() {
        pdfIframe.src = '';
    });
});
</script>
@endpush
