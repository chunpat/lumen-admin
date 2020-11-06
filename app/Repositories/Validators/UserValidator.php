<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'password' => 'required|min:8',
            'nickname' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'phone' => 'required|unique:users|string',
            'email' => 'required|email|unique:users|max:100',
            'gender' => 'integer|between:1,3',
            'avatar' => 'string',
            'status' => 'integer|between:0,1',
            'introduction' => 'string',
            'role_ids' => 'array',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required',
            'name' => 'required|string|max:100',
            'phone' => 'required|string',
//            'password' => 'required|min:8',
            'nickname' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'gender' => 'integer|between:1,3',
            'avatar' => 'string',
            'status' => 'integer|between:0,1',
            'introduction' => 'string',
            'role_ids' => 'array',
        ],
    ];
}
