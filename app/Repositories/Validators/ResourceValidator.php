<?php

namespace App\Repositories\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ResourceValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|max:100',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required|integer',
            'name' => 'required|string|max:100',
        ],
    ];
}
