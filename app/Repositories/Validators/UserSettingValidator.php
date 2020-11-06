<?php

namespace App\Repositories\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class UserSettingValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required|integer',
            'theme_color' => 'required|string',
            'open_tags_view' => 'required|integer|between:0,1',
            'fixed_header' => 'required|integer|between:0,1',
            'sidebar_logo' => 'required|integer|between:0,1',
        ],
    ];
}
