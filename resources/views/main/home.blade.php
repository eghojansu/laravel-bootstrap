<x-layout>
  <div class="min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card w-75">
      <div class="card-body">
        <h3 class="card-title">{{ config('app.name') }}</h3>

        <figure class="mt-5">
          <blockquote class="blockquote">
            <p>{{ $quote['text'] }}</p>
          </blockquote>
          <figcaption class="blockquote-footer">
            {{ $quote['by'] }}
          </figcaption>
        </figure>

        <div class="mt-5">
          <a href="{{ route('dashboard') }}" class="btn btn-primary">
            <i class="bi-house"></i> Dashboard
          </a>
        </div>
      </div>
    </div>
  </div>
</x-layout>
