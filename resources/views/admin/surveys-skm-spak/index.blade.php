@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light p-3 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Survey SKM & SPAK</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-poll me-2"></i> Manajemen Survey SKM & SPAK
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    @if($statistics['total_responden'] > 0)
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Responden</span>
                    <span class="info-box-number">{{ $statistics['total_responden'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Rata-rata SKM</span>
                    <span class="info-box-number">{{ $statistics['skm_average'] ?? 'N/A' }}/4.0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-shield-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Rata-rata SPAK</span>
                    <span class="info-box-number">{{ $statistics['spak_average'] ?? 'N/A' }}/4.0</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-star"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Rata-rata Keseluruhan</span>
                    <span class="info-box-number">{{ $statistics['total_average'] ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Survey List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-poll mr-2"></i>
                        Daftar Responden Survey
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.surveys-skm-spak.export', request()->query()) }}" class="btn btn-success btn-sm" title="Export data ke Excel">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('admin.surveys-skm-spak.index') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="kategori_responden" class="form-control">
                                            <option value="">-- Semua Kategori --</option>
                                            @foreach($kategoris as $kat)
                                                <option value="{{ $kat }}" {{ request('kategori_responden') == $kat ? 'selected' : '' }}>
                                                    {{ $kat }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="jenis_pelayanan" class="form-control">
                                            <option value="">-- Semua Pelayanan --</option>
                                            @foreach($layananList as $layanan)
                                                <option value="{{ $layanan }}" {{ request('jenis_pelayanan') == $layanan ? 'selected' : '' }}>
                                                    {{ $layanan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" placeholder="Dari Tanggal">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" placeholder="Hingga Tanggal">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                        <a href="{{ route('admin.surveys-skm-spak.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Results Count -->
                    @if($surveys->total() > 0)
                    <p class="text-muted">
                        Menampilkan {{ $surveys->firstItem() ?? 0 }} - {{ $surveys->lastItem() ?? 0 }}
                        dari {{ $surveys->total() }} survey
                    </p>
                    @endif

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="60">No</th>
                                    <th>Kategori</th>
                                    <th>Unit Kerja</th>
                                    <th>Jenis Pelayanan</th>
                                    <th>Skor SKM</th>
                                    <th>Skor SPAK</th>
                                    <th>Tanggal</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surveys as $index => $survey)
                                    <tr>
                                        <td>{{ $surveys->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge {{ strpos($survey->kategori_responden, 'Internal') !== false ? 'badge-primary' : 'badge-info' }}">
                                                {{ $survey->kategori_responden }}
                                            </span>
                                        </td>
                                        <td>{{ $survey->unit_kerja }}</td>
                                        <td>{{ $survey->jenis_pelayanan }}</td>
                                        <td>
                                            <span class="badge badge-success">
                                                {{ $survey->getSkmAverage() ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">
                                                {{ $survey->getSpakAverage() ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ $survey->created_at->locale('id')->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.surveys-skm-spak.show', $survey->id) }}" class="btn btn-info btn-sm" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteId({{ $survey->id }})" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Tidak ada data survey ditemukan</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($surveys->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="text-muted">
                                    Menampilkan {{ $surveys->firstItem() }} - {{ $surveys->lastItem() }}
                                    dari {{ $surveys->total() }} survey
                                </small>
                            </div>
                            <div>
                                {{ $surveys->appends(request()->query())->links('admin-pagination') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash mr-2"></i> Hapus Survey
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus survey ini?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setDeleteId(id) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ route('admin.surveys-skm-spak.destroy', ':id') }}`.replace(':id', id);
    }
</script>
@endsection
