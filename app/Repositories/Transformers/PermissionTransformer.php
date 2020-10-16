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

use App\Repositories\Models\Permission;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'name' => $permission->name,
            'title' => $permission->title,
            'type' => $permission->type,
            'icon' => $permission->icon,
            'path' => $permission->path,
            'paths' => $permission->paths,
            'component' => $permission->component,
            'is_redirect' => $permission->is_redirect,
            'is_affix' => $permission->is_affix,
            'is_always_show' => $permission->is_always_show,
            'is_hidden' => $permission->is_hidden,
            'is_no_cache' => $permission->is_no_cache,
            'parent_id' => $permission->parent_id,
            'sort' => $permission->sort,
            'created_at' => $permission->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
