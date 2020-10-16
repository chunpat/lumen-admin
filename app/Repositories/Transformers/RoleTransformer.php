<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories\Transformers;

use App\Repositories\Models\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'en' => $user->en,
            'status' => $user->status,
            'remark' => $user->en,
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
