<form {!! clsr(array(
  'class' => array(
    'row' => $grid,
    'g-' . $gap => $grid,
    $attributes->get('class'),
  ),
  'method' => $method,
  'novalidate' => !$validate,
  'autocomplete' => $autocomplete ? null : 'off',
)) !!}>
  {{ $header ?? null }}
  <x-alert type="danger" />
  <x-alert type="success" />
  <x-alert type="info" />
  <x-alert type="warning" />
  {{ $slot }}
  @if ($submit)
    <div class="border-top pt-3">
      <button type="submit" class="btn btn-primary">
        <i class="bi-check2-circle me-1"></i>
        <span>{{ $saveText }}</span>
      </button>
      <a href="{{ route($back) }}" class="btn btn-secondary ms-2">
        <i class="bi-x-circle me-1"></i>
        <span>{{ $backText }}</span>
      </a>
    </div>
  @endif
  {{ $footer ?? null }}
  @csrf
</form>
