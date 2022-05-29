<x-layout page-title="Login">
  <div class="min-vh-100 d-flex justify-content-center align-items-center">
    <form class="text-center" method="post" autocomplete="off" novalidate>
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <x-form-float name="account" label="Email or username" class="mb-3">
        <x-form-input name="account" required />
      </x-form-float>
      <x-form-float name="password" class="mb-3">
        <x-form-input name="password" type="password" required />
      </x-form-float>
      <x-form-check name="remember" value="remember" label="Remember me" />

      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; {{ config('app.year') }}</p>
      @csrf
    </form>
  </div>

  <x-slot name="styles">
    <style>
      body {
        background-color: #f5f5f5;
      }
      form {
        width: 300px;
      }
    </style>
  </x-slot>
</x-layout>
