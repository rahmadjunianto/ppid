@extends('admin.layouts.app')<% SYSTEM %>@section('title', 'Detail Informasi Berkala')<% SYSTEM %>@section('breadcrumb')
        <% SYSTEM %>
            <li class="breadcrumb-item"><a href="{{ route('admin.informasi-berkala.index') }}">Informasi Berkala</a>
            </li>
            <% SYSTEM %>
                <li class="breadcrumb-item active">Detail</li>
                <% SYSTEM %>@endsection<% SYSTEM %>@section('content')<% SYSTEM %>
                            <div class="row">
                                <% SYSTEM %>
                                    <div class="col-12">
                                        <% SYSTEM %>
                                            <div class="card">
                                                <% SYSTEM %>
                                                    <div class="card-header">
                                                        <% SYSTEM %>
                                                            <h3 class="card-title"><i
                                                                    class="fas fa-info-circle mr-2"></i>Detail Informasi
                                                                Berkala</h3>
                                                            <% SYSTEM %>
                                                                <div class="card-tools">
                                                                    <% SYSTEM %> <a
                                                                            href="{{ route('admin.informasi-berkala.edit', $informasiBerkala) }}"
                                                                            class="btn btn-warning btn-sm">
                                                                            <% SYSTEM %> <i class="fas fa-edit"></i>
                                                                                Edit<% SYSTEM %>
                                                                        </a>
                                                                        <% SYSTEM %> <a
                                                                                href="{{ route('admin.informasi-berkala.index') }}"
                                                                                class="btn btn-default btn-sm">
                                                                                <% SYSTEM %> <i
                                                                                        class="fas fa-arrow-left"></i>
                                                                                    Kembali<% SYSTEM %>
                                                                            </a>
                                                                            <% SYSTEM %>
                                                                </div>
                                                                <% SYSTEM %>
                                                    </div>
                                                    <% SYSTEM %>
                                                        <div class="card-body">
                                                            <% SYSTEM %>
                                                                <table class="table table-bordered">
                                                                    <% SYSTEM %>
                                                                        <tr>
                                                                            <% SYSTEM %>
                                                                                <th>Kategori</th>
                                                                                <% SYSTEM %>
                                                                                    <td><span
                                                                                            class="badge badge-primary">{{
                                                                                            $informasiBerkala->kategori
                                                                                            }}</span></td>
                                                                                    <% SYSTEM %>
                                                                        </tr>
                                                                        <% SYSTEM %>
                                                                            <tr>
                                                                                <% SYSTEM %>
                                                                                    <th>Judul</th>
                                                                                    <% SYSTEM %>
                                                                                        <td><strong>{{
                                                                                                $informasiBerkala->judul
                                                                                                }}</strong></td>
                                                                                        <% SYSTEM %>
                                                                            </tr>
                                                                            <% SYSTEM %>
                                                                                <tr>
                                                                                    <% SYSTEM %>
                                                                                        <th>Link</th>
                                                                                        <% SYSTEM %>
                                                                                            <td>{{
                                                                                                $informasiBerkala->link
                                                                                                ?: '-' }}</td>
                                                                                            <% SYSTEM %>
                                                                                </tr>
                                                                                <% SYSTEM %>
                                                                                    <tr>
                                                                                        <% SYSTEM %>
                                                                                            <th>Status</th>
                                                                                            <% SYSTEM %>
                                                                                                <td>{{
                                                                                                    $informasiBerkala->status
                                                                                                    }}</td>
                                                                                                <% SYSTEM %>
                                                                                    </tr>
                                                                                    <% SYSTEM %>
                                                                </table>
                                                                <% SYSTEM %>
                                                        </div>
                                                        <% SYSTEM %>
                                            </div>
                                            <% SYSTEM %>
                                    </div>
                                    <% SYSTEM %>
                            </div>
                            <% SYSTEM %>@endsection