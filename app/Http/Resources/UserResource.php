<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'phone' => $this->phone,
            'email' => $this->email,
            'avatar' => $this->avatar ?:'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
            'introduction' => $this->introduction,
            'status' => $this->status,
            'gender' => $this->gender,
            'user_setting' => $this->user_setting,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
