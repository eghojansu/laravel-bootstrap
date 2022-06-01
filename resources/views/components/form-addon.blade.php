@if ($isButton())
  <button tabindex="-1" class="btn btn-outline-{{ $variant }}" type="button" data-id="{{ $id }}" title="{{ $title }}" data-toggle="tooltip">
    <x-form-content :text="$text" :icon="$icon" />
  </button>
@else
  <span tabindex="-1" class="input-group-text" data-id="{{ $id }}" title="{{ $title }}" data-toggle="tooltip">
    <x-form-content :text="$text" :icon="$icon" />
  </span>
@endif
