<?php

namespace App\Repositories\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SettingValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'key' => 'required|string|max:50|unique:setting',
            'title' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'value' => 'required|string|max:255',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required',
            'key' => 'required|string|max:50|unique:setting',
            'title' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'value' => 'required|string|max:255',
        ],
    ];
}
