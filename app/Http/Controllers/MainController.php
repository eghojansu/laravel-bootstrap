<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function home()
    {
        return view('main.home', array(
            'quote' => $this->pref->getQuote(),
        ));
    }

    public function login()
    {
        return view('main.login');
    }

    public function loginCheck()
    {
        $data = $this->validateWith(array(
            'account' => 'required|string',
            'password' => 'required|string',
            'remember' => 'nullable',
        ));
        $result = $this->account->attempt(
            $data['account'],
            $data['password'],
            $data['remember'],
        );

        if ($result['success']) {
            return redirect($result['data']['redirect'])->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
