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

use App\Repositories\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'phone' => $user->phone,
            'avatar' => $user->avatar,
            'introduction' => $user->introduction,
            'status' => $user->status,
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
