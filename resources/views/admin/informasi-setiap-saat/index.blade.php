@extends("admin.layouts.app")

@section("title", "Kelola Informasi Setiap Saat")
@section("page-title", "Kelola Informasi Setiap Saat")

@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
<li class="breadcrumb-item active">Kelola Informasi Setiap Saat</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list-alt mr-2"></i>
                    Daftar Informasi Setiap Saat
                </h3>
                <div class="card-tools">
                    <a href="{{ route("admin.informasi-setiap-saat.create") }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Informasi
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session("success"))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session("success") }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <!-- Filter -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route("admin.informasi-setiap-saat.index") }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" class="form-control" placeholder="Cari informasi setiap saat..."
                                        value="{{ request("search") }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="link_type" class="form-control">
                                        <option value="">Semua Tipe Link</option>
                                        @foreach($linkTypeOptions as $key => $label)
                                        <option value="{{ $key }}" {{ request("link_type")==$key ? "selected" : "" }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="draft" {{ request("status")=="draft" ? "selected" : "" }}>Draft
                                        </option>
                                        <option value="published" {{ request("status")=="published" ? "selected" : "" }}>Published
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route("admin.informasi-setiap-saat.index") }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if($informasi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th>Judul</th>
                                <th width="100" class="text-center">Tipe</th>
                                <th width="80" class="text-center">Status</th>
                                <th width="120" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($informasi as $key => $item)
                            <tr>
                                <td class="text-center">{{ $informasi->firstItem() + $key }}</td>
                                <td><strong>{{ $item->judul }}</strong></td>
                                <td class="text-center">{!! $item->link_type_badge !!}</td>
                                <td class="text-center">{!! $item->status_badge !!}</td>
                                <td class="text-center">
                                    <a href="{{ route("admin.informasi-setiap-saat.show", $item) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route("admin.informasi-setiap-saat.edit", $item) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route("admin.informasi-setiap-saat.destroy", $item) }}" method="POST" style="display:inline">
                                        @csrf @method("DELETE")
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Yakin?")"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if($informasi->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $informasi->firstItem() }} - {{ $informasi->lastItem() }}
                            dari {{ $informasi->total() }} Informasi Setiap Saat
                        </small>
                    </div>
                    <div>
                        {{ $informasi->appends(request()->query())->links("admin-pagination") }}
                    </div>
                </div>
                @endif
                @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data</p>
                    <a href="{{ route("admin.informasi-setiap-saat.create") }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
