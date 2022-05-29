<div {{ $attributes->class(array('form-check'))->only('class') }}>
  <input {{ $attributes->class(array(
    'form-check-input',
    'is-invalid' => $errors->has($name)
  ))->merge(array(
    'type' => 'checkbox',
    'id' => $id,
    'name' => $name,
  )) }} />
  <label class="form-check-label" for="{{ $id }}">
    {{ $label }}
  </label>
  @if ($errors->has($name))<div class="invalid-feedback">{{ $errors->first($name) }}</div>@endif
</div>
