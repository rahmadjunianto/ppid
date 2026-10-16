@extends("admin.layouts.app")

@section("title", "Kelola Informasi Berkala")
@section("page-title", "Kelola Informasi Berkala")

@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Dashboard</a></li>
<li class="breadcrumb-item active">Kelola Informasi Berkala</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list-alt mr-2"></i>
                    Daftar Informasi Berkala
                </h3>
                <div class="card-tools">
                    <a href="{{ route("admin.informasi-berkala.create") }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Informasi
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session("success"))
                    <div class="alert alert-success">{{ session("success") }}</div>
                @endif
                <form method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari judul..." value="{{ request("search") }}">
                        </div>
                        <div class="col-md-3">
                            <select name="kategori" class="form-control">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriOptions as $key => $label)
                                    <option value="{{ $key }}" {{ request("kategori") == $key ? "selected" : "" }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">Semua</option>
                                <option value="published" {{ request("status") == "published" ? "selected" : "" }}>Published</option>
                                <option value="draft" {{ request("status") == "draft" ? "selected" : "" }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Filter</button>
                            <a href="{{ route("admin.informasi-berkala.index") }}" class="btn btn-default"><i class="fas fa-times"></i> Reset</a>
                        </div>
                    </div>
                </form>
                @if($informasi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th width="100" class="text-center">Kategori</th>
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
                                <td class="text-center">
                                    <span class="badge badge-{{ ["A"=>"primary","B"=>"success","C"=>"info","D"=>"warning","E"=>"secondary"][$item->kategori] ?? "secondary" }}">
                                        Kategori {{ $item->kategori }}
                                    </span>
                                </td>
                                <td><strong>{{ $item->judul }}</strong></td>
                                <td class="text-center">{!! $item->link_type_badge !!}</td>
                                <td class="text-center">{!! $item->status_badge !!}</td>
                                <td class="text-center">
                                    <a href="{{ route("admin.informasi-berkala.show", $item) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route("admin.informasi-berkala.edit", $item) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route("admin.informasi-berkala.destroy", $item) }}" method="POST" style="display:inline">
                                        @csrf @method("DELETE")
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm("Yakin?")"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $informasi->appends(request()->query())->links("admin-pagination") }}
                @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data</p>
                    <a href="{{ route("admin.informasi-berkala.create") }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
