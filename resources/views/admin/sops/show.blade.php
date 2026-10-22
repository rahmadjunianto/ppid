@extends('admin.layouts.app')

@section('title', 'Detail SOP')
@section('page-title', 'Detail SOP')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.sops.index') }}">Kelola SOP</a></li>
    <li class="breadcrumb-item active">Detail SOP</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt mr-2"></i>
                        Detail Dokumen SOP
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sops.edit', $sop) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.sops.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="25%">Nama Dokumen</th>
                                    <td><strong>{{ $sop->nama_dokumen }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Grup</th>
                                    <td>
                                        <span class="badge badge-{{ $sop->grup == 'SOP PPID' ? 'info' : 'warning' }}">
                                            {{ $sop->grup_label }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nomor SOP</th>
                                    <td>{{ $sop->nomor ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td>{{ $sop->tahun ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Ukuran File</th>
                                    <td>{{ $sop->ukuran_formatted }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Dilihat</th>
                                    <td>
                                        <span class="badge badge-light">
                                            <i class="fas fa-eye mr-1"></i>{{ $sop->view_count ?? 0 }} kali dilihat
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{!! $sop->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>File</th>
                                    <td>
                                        @if($sop->file)
                                            <a href="{{ asset('storage/' . $sop->file) }}" class="btn btn-success btn-sm" target="_blank">
                                                <i class="fas fa-download"></i> Download File
                                            </a>
                                            <small class="text-muted ml-2">{{ $sop->file }}</small>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order</th>
                                    <td>{{ $sop->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>{{ $sop->created_at ? $sop->created_at->format('d F Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui Pada</th>
                                    <td>{{ $sop->updated_at ? $sop->updated_at->format('d F Y H:i') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

