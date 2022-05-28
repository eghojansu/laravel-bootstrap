<x-layout page-title="Login">
  <div class="min-vh-100 d-flex justify-content-center align-items-center">
    <form class="text-center">
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div class="form-floating">
        <input type="text" class="form-control" name="account" id="input-account" placeholder="Email or username" value="{{ old('account') }}">
        <label for="input-account">Account</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="password" id="input-password" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" name="remember" value="on"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; {{ config('app.year') }}</p>
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
      .form-floating:focus-within {
        z-index: 2;
      }
      [name=account] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }
      [name=password] {
        margin-bottom: 10px;
        border-top-right-radius: 0;
        border-top-left-radius: 0;
      }
    </style>
  </x-slot>
</x-layout>
