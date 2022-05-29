<x-layout :title="$title" :page-title="$pageTitle" :default-title="$defaultTitle" {{ $attributes }}>
  <x-slot name="scripts">
    @tag('dashboard')
    {{ $scripts ?? null }}
  </x-slot>
  <x-slot name="styles">
    {{ $styles ?? null }}
  </x-slot>

  <header class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <nav class="container-fluid">
      <button class="navbar-toggler d-block me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sideMenu" aria-controls="sideMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <x-navbar-menu group="ac" end="true"></x-navbar-menu>
      </div>
    </nav>
  </header>
  <nav class="offcanvas offcanvas-start" tabindex="-1" id="sideMenu" aria-labelledby="sideMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sideMenuLabel">{{ config('app.name') }}</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
      <x-nav-tree group="db" />
    </div>
  </nav>
  <main class="db-main">
    {{ $slot }}
  </main>
</x-layout>
