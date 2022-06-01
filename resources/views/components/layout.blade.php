<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $_pageTitle }}</title>
  @client
  @tag('shared.sass')
  @tag('shared.js')
  @tag('common.js')
  {{ $styles ?? null }}
  {{ $scripts ?? null }}
</head>
<body {{ $attributes }}>
  <noscript>Please enable Javascript in your browser</noscript>

  {{ $slot }}
</body>
</html>
