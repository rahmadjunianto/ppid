@extends('admin.layouts.app')

@section('title', 'Detail Regulasi')
@section('page-title', 'Detail Regulasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.regulasi.index') }}">Kelola Regulasi</a></li>
    <li class="breadcrumb-item active">Detail Regulasi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-book mr-2"></i>
                        Detail Regulasi &amp; Peraturan
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.regulasi.edit', $regulasi->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.regulasi.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="25%">Nama Regulasi</th>
                                    <td><strong>{{ $regulasi->nama_regulasi }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Nomor</th>
                                    <td>{{ $regulasi->nomor ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tingkat</th>
                                    <td>{!! $regulasi->tingkat_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td>{{ $regulasi->tahun ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Sumber Dokumen</th>
                                    <td>
                                        @if($regulasi->link_type === 'file')
                                            <span class="badge badge-info">Upload File</span>
                                        @else
                                            <span class="badge badge-secondary">Tautan Eksternal</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ukuran File</th>
                                    <td>{{ $regulasi->ukuran_formatted }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Dilihat</th>
                                    <td>
                                        <span class="badge badge-light">
                                            <i class="fas fa-eye mr-1"></i>{{ $regulasi->view_count ?? 0 }} kali dilihat
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{!! $regulasi->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>Dokumen</th>
                                    <td>
                                        @if($regulasi->link_type === 'file' && $regulasi->file)
                                            <a href="{{ asset('storage/' . $regulasi->file) }}" class="btn btn-success btn-sm" target="_blank">
                                                <i class="fas fa-download"></i> Download File
                                            </a>
                                            <small class="text-muted ml-2">{{ $regulasi->file }}</small>
                                        @elseif($regulasi->link_type === 'link' && $regulasi->link_url)
                                            <a href="{{ $regulasi->link_url }}" class="btn btn-success btn-sm" target="_blank">
                                                <i class="fas fa-external-link-alt"></i> Buka Tautan
                                            </a>
                                            <small class="text-muted ml-2">{{ $regulasi->link_url }}</small>
                                        @else
                                            <span class="text-muted">Tidak ada dokumen</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order</th>
                                    <td>{{ $regulasi->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>{{ $regulasi->created_at ? $regulasi->created_at->format('d F Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui Pada</th>
                                    <td>{{ $regulasi->updated_at ? $regulasi->updated_at->format('d F Y H:i') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
