<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

class MainController extends Controller
{
    public function login()
    {
        list(
            'username' => $username,
            'password' => $password,
            'remember' => $remember,
        ) = $this->validateWith(array(
            'username' => 'required|string',
            'password' => 'required|string',
            'remember' => 'nullable',
        ));
        $attempt = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'userid';
        $credentials = array($attempt => $username, 'active' => 1) + compact('password');

        if (auth()->attempt($credentials, !!$remember)) {
            /** @var User */
            $user = auth()->user();

            return $this->data($user->publish());
        }

        return $this->fail('Invalid credentials');
    }
}
