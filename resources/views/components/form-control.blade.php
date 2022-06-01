<div {!! clsr(array(
  'class' => array(
    'col-' . $breakpoint . '-' . $width => $isCol(),
    'mb-' . $mb => $mb > 0,
  ),
)) !!}>
  @if (!$float)
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
  @endif
  <div {!! clsr(array(
    'class' => array(
      'form-floating' => $float && !$isCheck(),
      'form-check' => $isCheck(),
      'input-group' => $isGroup(),
      'has-validation' => $errors->has($name),
    ),
  )) !!}>
    <input {!! clsr(array(
      'class' => array(
        'form-control-plaintext' => $plain,
        'form-control' => !$plain && $isControl(),
        'form-check-input' => $isCheck(),
        'is-invalid' => $errors->has($name)
      ),
      'id' => $id,
      'name' => $name,
      'type' => $type,
      'value' => $isEmpty() ? null : $value(),
      'readonly' => $readonly || $plain,
      'placeholder' => $isCheck() ? null : $placeholder(),
      'aria-describedby' => $hint ? $idHelp() : null,
    ) + $attributes->getAttributes()) !!} />
    @foreach ($addonsEnd() as $addonId => $addon)
      <x-form-addon
        :id="$addonId"
        :type="$addon['type']"
        :icon="$addon['icon'] ?? null"
        :text="$addon['text'] ?? null"
        :title="$addon['title'] ?? null" />
    @endforeach
    @if ($float)
      <label for="{{ $id }}">{{ $label }}</label>
    @endif
    @if ($hint)
      <div class="form-text w-100" id="{{ $idHelp() }}">{{ $hint }}</div>
    @endif
    @if ($errors->has($name))
      <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
  </div>
</div>
@if ($isGrid() && $break)<div class="w-100"></div>@endif
