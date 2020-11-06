<?php

namespace App\Repositories\Transformers;

use App\Repositories\Models\Resource;
use League\Fractal\TransformerAbstract;

class ResourceTransformer extends TransformerAbstract
{
   /**
    * Prepare data to present.
    *
    * @param Resource $resource
    * @return array
    */
    public function transform(Resource $resource)
    {
        return [
            'id' => $resource->id,
            'created_at' => $resource->created_at ? $resource->created_at->format('Y-m-d H:i:s') : null,
        ];
    }
}