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

use App\Repositories\Models\Logs;
use League\Fractal\TransformerAbstract;

class LogsTransformer extends TransformerAbstract
{
    public function transform(Logs $logs)
    {
        return [
            'error_level' => $logs->error_level,
            'message' => $logs->message,
        ];
    }
}
