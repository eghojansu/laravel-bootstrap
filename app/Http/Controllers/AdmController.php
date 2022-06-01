<?php

namespace App\Http\Controllers;

use App\Models\Cspref;

class AdmController extends Controller
{
    public function preference()
    {
        return view('adm.preference', array(
            'prefs' => $this->pref->repo,
        ));
    }

    public function preferenceSave()
    {
        $data = $this->validateWith(
            $this->pref->repo->reduce(
                static function (array|null $rules, Cspref $pref) {
                    $rules[$pref->name] = 'required|string';

                    return $rules;
                },
            ),
        );

        $this->pref->update($data);

        return back()->with('success', trans('data.saved'));
    }
}
