@extends("admin.layouts.app")

@section("title", "Edit Informasi Berkala")

@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{ route("admin.informasi-berkala.index") }}">Informasi Berkala</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Edit Informasi Berkala</h3>
            </div>
            <form action="{{ route("admin.informasi-berkala.update", $informasiBerkala) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif
                    <div class="form-group">
                        <label for="kategori">Kategori <span class="text-danger">*</span></label>
                        <select class="form-control" id="kategori" name="kategori" required>
                            @foreach($kategoriOptions as $key => $label)
                                <option value="{{ $key }}" {{ $informasiBerkala->kategori == $key ? "selected" : "" }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $informasiBerkala->judul }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link_type">Tipe Link <span class="text-danger">*</span></label>
                                <select class="form-control" id="link_type" name="link_type" required>
                                    <option value="internal" {{ $informasiBerkala->link_type == "internal" ? "selected" : "" }}>Internal</option>
                                    <option value="external" {{ $informasiBerkala->link_type == "external" ? "selected" : "" }}>External</option>
                                    <option value="file" {{ $informasiBerkala->link_type == "file" ? "selected" : "" }}>File</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link">URL/Link</label>
                                <input type="text" class="form-control" id="link" name="link" value="{{ $informasiBerkala->link }}" placeholder="https://... atau /slug-halaman">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file">Upload File</label>
                        @if($informasiBerkala->file)
                            <div class="alert alert-info">
                                File saat ini: <a href="{{ asset("storage/" . $informasiBerkala->file) }}" target="_blank">{{ $informasiBerkala->file }}</a>
                            </div>
                        @endif
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
                                <label class="custom-file-label" for="file">Pilih file baru...</label>
                            </div>
                        </div>
                        <small class="text-muted">Format: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG. Maksimal: 10MB</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="draft" {{ $informasiBerkala->status == "draft" ? "selected" : "" }}>Draft</option>
                                    <option value="published" {{ $informasiBerkala->status == "published" ? "selected" : "" }}>Published</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sort_order">Urutan</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ $informasiBerkala->sort_order }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update</button>
                    <a href="{{ route("admin.informasi-berkala.index") }}" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
