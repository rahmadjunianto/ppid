@extends('admin.layouts.app')

@section('title', 'Edit Data')
@section('page-title', 'Edit Data')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.index') }}">Daftar Dinamis</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.items.index', $dynamicList) }}">{{ $dynamicList->title }}</a></li>
    <li class="breadcrumb-item active">Edit Data</li>
@endsection

@section('content')
<form action="{{ route('admin.lists.items.update', [$dynamicList, $item]) }}" method="POST" enctype="multipart/form-data" id="item-form">
    @csrf
    @method('PUT')

    <div class="card shadow-sm border-0">
        <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Data: {{ $dynamicList->title }}</h5>
        </div>

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

            <div class="row">
                @foreach($columns as $column)
                    <div class="col-md-6">
                        @include('admin.lists.items._field', [
                            'column' => $column,
                            'name' => 'item['.$column->key.']',
                            'oldPath' => 'item.'.$column->key,
                            'value' => $column->is_multiple ? $item->values($column->key) : $item->value($column->key),
                            'internalLinks' => $internalLinks,
                            'item' => $item,
                        ])
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Update Data
            </button>
            <a href="{{ route('admin.lists.items.index', $dynamicList) }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i> Batal
            </a>
        </div>
    </div>
</form>

@foreach($columns as $column)
    @if($column->isAction() && $column->action_type === 'internal')
        <datalist id="internal-links-{{ $column->id }}">
            @foreach($internalLinks as $link)
                <option value="{{ $link['value'] }}">{{ $link['label'] }}</option>
            @endforeach
        </datalist>
    @endif
@endforeach

@endsection

@push('scripts')
<script>
    (function () {
        var form = document.getElementById('item-form');

        form.addEventListener('click', function (e) {
            if (e.target.closest('.multi-remove')) {
                e.target.closest('.multi-value-group').remove();
            }

            if (e.target.closest('.multi-add')) {
                var wrapper = e.target.closest('.form-group');
                var container = wrapper.querySelector('[data-multi-container]');
                var lastGroup = container.querySelector('.multi-value-group:last-child');
                if (!lastGroup) {
                    return;
                }
                var clone = lastGroup.cloneNode(true);
                clone.querySelectorAll('input, select, textarea').forEach(function (el) {
                    el.value = '';
                    el.removeAttribute('id');
                });
                container.appendChild(clone);
            }
        });
    })();
</script>
@endpush
