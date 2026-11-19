@extends('admin.layouts.app')

@section('title', 'Tambah Daftar Dinamis')
@section('page-title', 'Tambah Daftar Dinamis')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.index') }}">Daftar Dinamis</a></li>
    <li class="breadcrumb-item active">Tambah Daftar</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Tambah Daftar Dinamis</h5>
    </div>

    <form action="{{ route('admin.lists.store') }}" method="POST">
        @csrf
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @include('admin.lists._form')
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Simpan Daftar
            </button>
            <a href="{{ route('admin.lists.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
