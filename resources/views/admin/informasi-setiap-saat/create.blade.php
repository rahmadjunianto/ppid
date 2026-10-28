@extends("admin.layouts.app")

@section("title", "Tambah Informasi Setiap Saat")

@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{ route("admin.informasi-setiap-saat.index") }}">Informasi Setiap Saat</a></li>
<li class="breadcrumb-item active">Tambah Baru</li>
@endsection

@section("content")
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus mr-2"></i>Tambah Informasi Setiap Saat</h3>
            </div>
            <form action="{{ route("admin.informasi-setiap-saat.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    @endif
                    <div class="form-group">
                        <label for="judul">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old("judul") }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link_type">Tipe Link <span class="text-danger">*</span></label>
                                <select class="form-control" id="link_type" name="link_type" required>
                                    @foreach($linkTypeOptions as $key => $label)
                                        <option value="{{ $key }}" {{ old("link_type") == $key ? "selected" : "" }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link">URL/Link</label>
                                <input type="text" class="form-control" id="link" name="link" value="{{ old("link") }}" placeholder="https://... atau /slug-halaman">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file">Upload File</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
                                <label class="custom-file-label" for="file">Pilih file...</label>
                            </div>
                        </div>
                        <small class="text-muted">Format: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG. Maksimal: 10MB</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="draft" {{ old("status") == "draft" ? "selected" : "" }}>Draft</option>
                                    <option value="published" {{ old("status") == "published" ? "selected" : "" }}>Published</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sort_order">Urutan</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old("sort_order", 0) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route("admin.informasi-setiap-saat.index") }}" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
