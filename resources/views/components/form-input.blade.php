<input {{ $attributes->class(array(
  'form-control',
  'is-invalid' => $errors->has($name)
))->merge(array(
  'type' => $type ?? 'text',
  'id' => $id,
  'name' => $name,
  'value' => old($name),
  'placeholder' => $hint,
)) }} />
@if ($errors->has($name))<div class="invalid-feedback">{{ $errors->first($name) }}</div>@endif
