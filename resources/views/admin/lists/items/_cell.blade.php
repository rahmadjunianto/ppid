@php
    // $column : App\Models\DynamicListColumn
    // $item   : App\Models\DynamicListItem
@endphp

@if($column->isFileType())
    @php $columnFiles = $item->files->where('dynamic_list_column_id', $column->id); @endphp
    @forelse($columnFiles as $columnFile)
        <a href="{{ route('lists.file.download', $columnFile->id) }}" class="d-block small text-truncate"
           style="max-width: 180px;" title="{{ $columnFile->original_name }}">
            <i class="fas fa-paperclip me-1"></i>{{ $columnFile->original_name }}
        </a>
    @empty
        <span class="text-muted small">-</span>
    @endforelse
@elseif($column->is_multiple)
    @php $values = $item->values($column->key); @endphp
    @if(count($values))
        @foreach($values as $single)
            @if($column->type === 'select')
                <span class="badge bg-light text-dark border me-1">{{ $column->optionLabel((string) $single) }}</span>
            @elseif($column->isAction())
                @if($column->action_type === 'external')
                    <a href="{{ $single }}" target="_blank" rel="noopener" class="badge bg-info text-white text-decoration-none me-1">
                        <i class="fas fa-external-link-alt me-1"></i>{{ Str::limit($single, 24) }}
                    </a>
                @else
                    <a href="{{ url($single) }}" class="badge bg-secondary text-white text-decoration-none me-1">
                        <i class="fas fa-link me-1"></i>{{ Str::limit($single, 24) }}
                    </a>
                @endif
            @else
                <span class="badge bg-light text-dark border me-1">{{ $single }}</span>
            @endif
        @endforeach
    @else
        <span class="text-muted small">-</span>
    @endif
@elseif($column->type === 'select')
    {{ $column->optionLabel($item->value($column->key) !== null ? (string) $item->value($column->key) : null) ?? '-' }}
@elseif($column->type === 'boolean')
    {{ $item->value($column->key) ? 'Ya' : 'Tidak' }}
@elseif($column->isAction())
    @php $actionValue = $item->value($column->key); @endphp
    @if($actionValue)
        @if($column->action_type === 'external')
            <a href="{{ $actionValue }}" target="_blank" rel="noopener" class="small">
                <i class="fas fa-external-link-alt me-1"></i>{{ Str::limit($actionValue, 30) }}
            </a>
        @else
            <a href="{{ url($actionValue) }}" class="small">
                <i class="fas fa-link me-1"></i>{{ $actionValue }}
            </a>
        @endif
    @else
        <span class="text-muted small">-</span>
    @endif
@else
    {{ $item->value($column->key) ?? '-' }}
@endif

