<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Log extends Model
{
    protected $connection = 'mongodb';

    protected $guarded = [];

    protected $dates = [
        'datetime',
    ];
}
