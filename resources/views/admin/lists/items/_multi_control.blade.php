@php
    // $column    : App\Models\DynamicListColumn
    // $fieldName : nama field HTML untuk input
    // $multiValue: nilai yang ditampilkan
    $isAction = $column->isAction();
@endphp

@if($column->type === 'select')
    <select class="form-select form-select-sm" name="{{ $fieldName }}">
        <option value="">-- Pilih --</option>
        @foreach($column->optionPairs() as $opt)
            <option value="{{ $opt['value'] }}" {{ (string) $opt['value'] === (string) $multiValue ? 'selected' : '' }}>
                {{ $opt['label'] ?? $opt['value'] }}
            </option>
        @endforeach
    </select>
@elseif($isAction && $column->action_type === 'internal')
    <input type="text" list="internal-links-{{ $column->id }}" class="form-control form-control-sm"
           name="{{ $fieldName }}" value="{{ $multiValue }}" placeholder="/halaman-tujuan">
@elseif($isAction && $column->action_type === 'external')
    <input type="url" class="form-control form-control-sm" name="{{ $fieldName }}" value="{{ $multiValue }}"
           placeholder="https://contoh.go.id">
@elseif($column->type === 'number')
    <input type="number" step="any" class="form-control form-control-sm" name="{{ $fieldName }}" value="{{ $multiValue }}">
@elseif($column->type === 'date')
    <input type="date" class="form-control form-control-sm" name="{{ $fieldName }}" value="{{ $multiValue }}">
@elseif($column->type === 'textarea')
    <textarea class="form-control form-control-sm" name="{{ $fieldName }}" rows="3">{{ $multiValue }}</textarea>
@else
    <input type="text" class="form-control form-control-sm" name="{{ $fieldName }}" value="{{ $multiValue }}">
@endif
