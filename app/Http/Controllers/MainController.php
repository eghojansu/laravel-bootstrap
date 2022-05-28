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
        dd(request());
        $data = $this->validateWith(array(
            'username' => 'required|string',
            'password' => 'required|string',
            'remember' => 'nullable',
        ));
        $result = $this->account->attempt(
            $data['username'],
            $data['password'],
            $data['remember'],
        );

        if ($result['success']) {

        }
    }
}
