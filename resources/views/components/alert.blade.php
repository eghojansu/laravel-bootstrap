@if ($message = session($type))
<div {{ $attributes->class(array('alert', 'alert-' . $type, 'alert-dismissible fade show' => $dismiss))->only('class') }} role="alert">
  {{ $message }}
  @if ($dismiss)
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  @endif
</div>
@endif
