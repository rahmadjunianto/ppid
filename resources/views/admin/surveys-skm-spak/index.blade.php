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

    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter & Pencarian</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.surveys-skm-spak.index') }}" class="form-inline">
                        <div class="form-group mr-2 mb-2">
                            <label for="kategori_responden" class="mr-2">Kategori:</label>
                            <select name="kategori_responden" id="kategori_responden" class="form-control">
                                <option value="">-- Semua Kategori --</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat }}" {{ request('kategori_responden') == $kat ? 'selected' : '' }}>
                                        {{ $kat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-2 mb-2">
                            <label for="jenis_pelayanan" class="mr-2">Jenis Pelayanan:</label>
                            <select name="jenis_pelayanan" id="jenis_pelayanan" class="form-control">
                                <option value="">-- Semua Pelayanan --</option>
                                @foreach($layananList as $layanan)
                                    <option value="{{ $layanan }}" {{ request('jenis_pelayanan') == $layanan ? 'selected' : '' }}>
                                        {{ $layanan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-2 mb-2">
                            <label for="from_date" class="mr-2">Dari Tanggal:</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="form-group mr-2 mb-2">
                            <label for="to_date" class="mr-2">Hingga Tanggal:</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">
                            <i class="fas fa-search mr-2"></i> Cari
                        </button>
                        <a href="{{ route('admin.surveys-skm-spak.index') }}" class="btn btn-secondary ml-2 mb-2">
                            <i class="fas fa-redo mr-2"></i> Reset
                        </a>
                        <a href="{{ route('admin.surveys-skm-spak.export', request()->query()) }}" class="btn btn-success ml-2 mb-2" title="Export data ke Excel">
                            <i class="fas fa-file-excel mr-2"></i> Export Excel
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Survey List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Responden Survey</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Kategori</th>
                                <th>Unit Kerja</th>
                                <th>Jenis Pelayanan</th>
                                <th>Skor SKM</th>
                                <th>Skor SPAK</th>
                                <th>Tanggal</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surveys as $survey)
                                <tr>
                                    <td>{{ ($surveys->currentPage() - 1) * $surveys->perPage() + $loop->iteration }}</td>
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
                                        <a href="{{ route('admin.surveys-skm-spak.show', $survey->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteId({{ $survey->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                        Tidak ada data survey ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($surveys->total() > 0)
                <div class="card-footer">
                    {{ $surveys->links() }}
                </div>
                @endif
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
                <form id="deleteForm" method="POST" style="display: inline;">
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
