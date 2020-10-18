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

class PermissionValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|max:30',
            'title' => 'required|string|max:30',
            'type' => 'required|string|max:10',
            'icon' => 'required|string|max:30',
            'path' => 'required|string|max:100',
            'component' => 'required|string|max:30',
            'is_redirect' => 'integer|between:0,1',
            'is_affix' => 'integer|between:0,1',
            'is_always_show' => 'integer|between:0,1',
            'is_hidden' => 'integer|between:0,1',
            'is_no_cache' => 'integer|between:0,1',
            'parent_id' => 'integer',
            'sort' => 'integer',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required|integer',
            'name' => 'required|string|max:30',
            'title' => 'required|string|max:30',
            'type' => 'required|string|max:10',
            'icon' => 'required|string|max:30',
            'path' => 'required|string|max:100',
            'component' => 'required|string|max:30',
            'is_redirect' => 'integer|between:0,1',
            'is_affix' => 'integer|between:0,1',
            'is_always_show' => 'integer|between:0,1',
            'is_hidden' => 'integer|between:0,1',
            'is_no_cache' => 'integer|between:0,1',
            'parent_id' => 'integer',
            'sort' => 'integer',
        ],
    ];
}
