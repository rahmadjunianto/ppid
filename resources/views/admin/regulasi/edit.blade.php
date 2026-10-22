@extends('admin.layouts.app')

@section('title', 'Edit Regulasi')
@section('page-title', 'Edit Regulasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.regulasi.index') }}">Kelola Regulasi</a></li>
    <li class="breadcrumb-item active">Edit Regulasi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Edit Regulasi: {{ $regulasi->nama_regulasi }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.regulasi.show', $regulasi->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Lihat</a>
                        <a href="{{ route('admin.regulasi.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
                <form action="{{ route('admin.regulasi.update', $regulasi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @include('admin.regulasi._form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Perubahan</button>
                        <a href="{{ route('admin.regulasi.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@include('admin.regulasi._script-toggle-source')
@endpush
