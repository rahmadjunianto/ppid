@extends('admin.layouts.app')

@section('title', 'Detail Informasi Berkala')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.informasi-berkala.index') }}">Informasi Berkala</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Detail Informasi Berkala</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.informasi-berkala.edit', $informasiBerkala) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.informasi-berkala.index') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Kategori</th>
                        <td><strong>{{ $informasiBerkala->kategori }}</strong> &mdash; {{ App\Models\InformasiBerkala::getKategoriLabel($informasiBerkala->kategori) }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td><strong>{{ $informasiBerkala->judul }}</strong></td>
                    </tr>
                    <tr>
                        <th>Tipe Link</th>
                        <td>{!! $informasiBerkala->link_type_badge !!}</td>
                    </tr>
                    <tr>
                        <th>Link</th>
                        <td>
                            @if($informasiBerkala->link)
                                <a href="{{ $informasiBerkala->link }}" target="_blank" rel="noopener">{{ $informasiBerkala->link }}</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>File</th>
                        <td>
                            @if($informasiBerkala->file)
                                <a href="{{ asset('storage/' . $informasiBerkala->file) }}" target="_blank">{{ $informasiBerkala->file }}</a>
                                <span class="text-muted">({{ $informasiBerkala->ukuran_formatted }})</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{!! $informasiBerkala->status_badge !!}</td>
                    </tr>
                    <tr>
                        <th>Urutan</th>
                        <td>{{ $informasiBerkala->sort_order }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $informasiBerkala->created_at ? $informasiBerkala->created_at->format('d F Y H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
