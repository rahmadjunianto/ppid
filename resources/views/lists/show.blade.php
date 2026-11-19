@extends('layouts.app')

@section('title', $dynamicList->title)

@section('content')
<div class="container my-4">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-page">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $dynamicList->title }}</li>
        </ol>
    </nav>

    @if($dynamicList->show_title)
        <div class="mb-3">
            <h4 class="fw-bold text-success mb-1">
                <i class="bi bi-list-ul me-2"></i>{{ $dynamicList->title }}
            </h4>
            @if($dynamicList->description)
                <p class="text-muted mb-0 small">{{ $dynamicList->description }}</p>
            @endif
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            @foreach($dynamicList->columns as $column)
                                <th>{{ $column->label }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                            <tr>
                                <td class="text-center text-muted">{{ $index + 1 }}</td>
                                @foreach($dynamicList->columns as $column)
                                    <td>
                                        @include('lists._cell', ['column' => $column, 'item' => $item])
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $dynamicList->columns->count() + 1 }}" class="text-center py-5">
                                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2 mb-0">Belum ada data pada daftar ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
