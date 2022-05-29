<div {{ $attributes->class(array('form-floating')) }}>
  {{ $slot }}
  <label for="{{ $id }}">{{ $label }}</label>
</div>
