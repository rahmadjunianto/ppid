@extends('admin.layouts.app')

@section('title', 'Data Survey')
@section('page-title', 'Data Survey')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Survey</li>
@endsection

@section('content')>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $statistics['total_responden'] }}</h3>
                            <p>Total Responden</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($statistics['rata_rata_kepuasan'], 1) }}/4</h3>
                            <p>Rata-rata Kepuasan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ round(($statistics['rata_rata_kepuasan'] / 4) * 100) }}%</h3>
                            <p>Tingkat Kepuasan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $statistics['distribusi_rating'][3] + $statistics['distribusi_rating'][4] }}</h3>
                            <p>Responden Puas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Responden Survey</h3>
                    <div class="card-tools">
                        {{-- <div class="btn-group">
                            <a href="{{ route('admin.surveys.export') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Export CSV
                            </a>
                            <a href="{{ route('admin.surveys.statistics') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-chart-bar"></i> Statistik Detail
                            </a>
                        </div> --}}
                    </div>
                </div>

                <div class="card-body">
                    <!-- Search and Filter -->
                    <form method="GET" class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control"
                                   placeholder="Cari nama, pekerjaan, atau saran..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="rating" class="form-control">
                                <option value="">Semua Rating</option>
                                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>Rating 1</option>
                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>Rating 2</option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>Rating 3</option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>Rating 4</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>

                    @if($surveys->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th>Nama</th>
                                    <th>Umur</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pekerjaan</th>
                                    <th>Rata-rata Rating</th>
                                    <th>Tanggal</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($surveys as $survey)
                                <tr>
                                    <td>{{ $survey->id }}</td>
                                    <td>{{ $survey->nama }}</td>
                                    <td>{{ $survey->umur }}</td>
                                    <td>{{ $survey->jenis_kelamin }}</td>
                                    <td>{{ $survey->pekerjaan }}</td>
                                    <td>
                                        @php
                                            $avgRating = $survey->getAverageRating();
                                        @endphp
                                        <span class="badge badge-{{ $avgRating >= 3 ? 'success' : ($avgRating >= 2 ? 'warning' : 'danger') }}">
                                            {{ number_format($avgRating, 1) }}/4.0
                                        </span>
                                    </td>
                                    <td>{{ $survey->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.surveys.show', $survey) }}"
                                               class="btn btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $survey->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <form id="delete-form-{{ $survey->id }}"
                                              action="{{ route('admin.surveys.destroy', $survey) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
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
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada data survey.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Data Survey?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush
@endsection
