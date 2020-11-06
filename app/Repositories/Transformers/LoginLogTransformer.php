<?php

namespace App\Repositories\Transformers;

use App\Repositories\Models\LoginLog;
use League\Fractal\TransformerAbstract;

class LoginLogTransformer extends TransformerAbstract
{
   /**
    * Prepare data to present.
    *
    * @param LoginLog $loginLog
    * @return array
    */
    public function transform(LoginLog $loginLog)
    {
        return [
            'id' => $loginLog->id,
            'name' => $loginLog->name,
            'ip' => $loginLog->ip,
            'location' => $loginLog->location,
            'browser' => $loginLog->browser,
            'platform' => $loginLog->platform,
            'status' => $loginLog->status,
            'created_at' => $loginLog->created_at ? $loginLog->created_at->format('Y-m-d H:i:s') : null,
        ];
    }
}