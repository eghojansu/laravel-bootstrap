<x-dashboard>
  <div id="db">
    <div class="p-5">
      <div class="d-flex">
        <div class="spinner-border text-primary me-3" role="status" aria-hidden="true"></div>
        <p>Loading...</p>
      </div>
    </div>
  </div>

  <x-slot name="scripts">
    <script type="module" src="{{ mix('js/dashboard.js') }}"></script>
  </x-slot>
</x-dashboard>
