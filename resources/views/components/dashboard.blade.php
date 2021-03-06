<x-layout :title="$title" :page-title="$pageTitle" :default-title="$defaultTitle" {{ $attributes }}>
  <x-slot name="scripts">
    <script src="{{ mix('assets/dashboard.js') }}"></script>
    {{ $scripts ?? null }}
  </x-slot>
  <x-slot name="styles">
    {{ $styles ?? null }}
  </x-slot>

  <header class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <nav class="container-fluid">
      <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <x-navbar-menu group="ac" end="true"></x-navbar-menu>
      </div>
    </nav>
  </header>
  <main class="db-main">
    {{ $slot }}
  </main>
</x-layout>
