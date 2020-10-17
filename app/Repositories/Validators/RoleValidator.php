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

class RoleValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|max:20',
            'en' => 'required|max:20',
            'remark' => 'required|max:255',
            'sort' => 'required|integer|max:127',
            'status' => 'required|integer|between:0,1',
            'menu_ids' => 'required|array',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required',
            'name' => 'required|max:20',
            'en' => 'required|max:20',
            'remark' => 'required|max:255',
            'sort' => 'required|integer|max:127',
            'status' => 'required|integer|between:0,1',
            'menu_ids' => 'required|array',
        ],
    ];
}
