@extends('admin.layouts.app')

@section('title', 'Detail Informasi Setiap Saat')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.informasi-setiap-saat.index') }}">Informasi Setiap Saat</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Detail Informasi Setiap Saat</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.informasi-setiap-saat.edit', $informasiSetiapSaat) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.informasi-setiap-saat.index') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Judul</th>
                        <td><strong>{{ $informasiSetiapSaat->judul }}</strong></td>
                    </tr>
                    <tr>
                        <th>Tipe Link</th>
                        <td>{!! $informasiSetiapSaat->link_type_badge !!}</td>
                    </tr>
                    <tr>
                        <th>Link</th>
                        <td>
                            @if($informasiSetiapSaat->link)
                                <a href="{{ $informasiSetiapSaat->link }}" target="_blank" rel="noopener">{{ $informasiSetiapSaat->link }}</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>File</th>
                        <td>
                            @if($informasiSetiapSaat->file)
                                <a href="{{ asset('storage/' . $informasiSetiapSaat->file) }}" target="_blank">{{ $informasiSetiapSaat->file }}</a>
                                <span class="text-muted">({{ $informasiSetiapSaat->ukuran_formatted }})</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{!! $informasiSetiapSaat->status_badge !!}</td>
                    </tr>
                    <tr>
                        <th>Urutan</th>
                        <td>{{ $informasiSetiapSaat->sort_order }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $informasiSetiapSaat->created_at ? $informasiSetiapSaat->created_at->format('d F Y H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
