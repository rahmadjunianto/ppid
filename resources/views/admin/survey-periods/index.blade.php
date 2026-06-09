{{-- Admin: Survey Periods Index --}}
@extends('admin.layouts.app')

@section('title', 'Kelola Periode Survei IKM/SPAK')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Kelola Periode Survei IKM/SPAK</h1>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-chart-line me-1"></i>
                Daftar Periode Survei
            </div>
            <a href="{{ route('admin.survey-periods.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Periode
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th class="text-center">IKM</th>
                        <th class="text-center">SPAK</th>
                        <th class="text-center">Responden</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($periods as $period)
                    <tr>
                        <td>
                            <strong>{{ $period->getPeriodLabel() }}</strong>
                            <br><small class="text-muted">{{ $period->year }}</small>
                        </td>
                        <td class="text-center">
                            @if($period->ikm_value)
                                <strong>{{ number_format($period->ikm_value, 2) }}</strong>
                                <br><span class="badge bg-{{ $period->getIkmCategoryInfo()['color'] }}">{{ $period->ikm_category_label }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($period->spak_value)
                                <strong>{{ number_format($period->spak_value, 2) }}</strong>
                                <br><span class="badge bg-{{ $period->getSpakCategoryInfo()['color'] }}">{{ $period->spak_category_label }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $period->total_respondents }} / {{ $period->target_respondents }}
                            <br><small class="text-muted">{{ number_format($period->response_rate ?? 0, 1) }}%</small>
                        </td>
                        <td class="text-center">
                            @if($period->is_published)
                                <span class="badge bg-success">Dipublikasi</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.survey-periods.edit', $period->id) }}" class="btn btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.survey-periods.toggle-publish', $period->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $period->is_published ? 'warning' : 'success' }}" title="{{ $period->is_published ? 'Batalkan Publikasi' : 'Publikasi' }}">
                                        <i class="fas fa-{{ $period->is_published ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.survey-periods.destroy', $period->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus periode ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Belum ada data periode survei
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="d-flex justify-content-center">
                {{ $periods->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
