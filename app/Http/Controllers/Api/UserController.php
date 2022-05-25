<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class UserController extends CrudController
{
    protected $modelKey = 'userid';

    protected function getData(Model $model = null): array
    {
        $key = $this->getModelKey();
        $data = $this->validateWith(array(
            $this->modelKey => array(
                'bail',
                'required',
                'string',
                'min:3',
                'max:8',
                'not_regex:/\\*+NEW\\*+/',
                Rule::unique($this->getModelClass(), $key)->ignore($model?->$key, $key),
            ),
            'name' => 'bail|required|string|min:3|max:32',
        ));

        return $data;
    }
}
