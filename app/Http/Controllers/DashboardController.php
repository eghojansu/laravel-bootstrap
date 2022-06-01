<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function home()
    {
        return view('dashboard.home');
    }

    public function logout()
    {
        return $this->account->logout();
    }

    public function profile()
    {
        return view('dashboard.profile', array(
            'user' => $this->user,
        ));
    }

    public function profileSave()
    {
        $data = $this->validateWith(array(
            'name' => 'required|string|max:32',
            'email' => array(
                'nullable',
                'string',
                Rule::unique(User::class)->ignore($this->user->id),
            ),
            'password' => 'required|current_password',
        ));
        unset($data['password']);

        $this->user->update($data);

        return back()->with('success', trans('data.saved'));
    }

    public function password()
    {
        return view('dashboard.password');
    }

    public function passwordSave()
    {
        $data = $this->validateWith(array(
            'new_password' => 'required|string|min:5',
            'password' => 'required|current_password',
        ));

        $this->user->newPassword($data['new_password']);

        return back()->with('success', trans('data.saved'));
    }
}
