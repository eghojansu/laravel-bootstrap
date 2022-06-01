<x-layout page-title="Login">
  <div class="min-vh-100 d-flex justify-content-center align-items-center">
    <x-form-container :grid="false" :submit="false" :autocomplete="false" class="text-center">
      <x-slot name="header">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
      </x-slot>

      <x-form-control width="-1" :float="true" mb="3" name="account" label="Email or username" required autofocus />
      <x-form-control width="-1" :float="true" mb="3" name="password" :view="false" type="password" required />
      <x-form-control width="-1" :float="true" mb="3" name="remember" label="Remember me" type="checkbox" />

      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; {{ config('app.year') }}</p>
    </x-form-container>
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
