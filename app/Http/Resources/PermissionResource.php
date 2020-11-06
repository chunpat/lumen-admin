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

class PermissionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'type' => $this->type,
            'icon' => $this->icon,
            'path' => $this->path,
            'paths' => $this->paths,
            'component' => $this->component,
            'is_redirect' => $this->is_redirect,
            'is_affix' => $this->is_affix,
            'is_always_show' => $this->is_always_show,
            'is_hidden' => $this->is_hidden,
            'is_no_cache' => $this->is_no_cache,
            'parent_id' => $this->parent_id,
            'sort' => $this->sort,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s'):'-',
        ];
    }
}
