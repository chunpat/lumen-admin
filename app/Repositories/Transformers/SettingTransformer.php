<?php

namespace App\Repositories\Transformers;

use App\Repositories\Models\Setting;
use League\Fractal\TransformerAbstract;

class SettingTransformer extends TransformerAbstract
{
   /**
    * Prepare data to present.
    *
    * @param Setting $setting
    * @return array
    */
    public function transform(Setting $setting)
    {
        return [
            'id' => $setting->id,
            'key' => $setting->key,
            'title' => $setting->title,
            'type' => $setting->type,
            'value' => $setting->value,
            'created_at' => $setting->created_at ? $setting->created_at->format('Y-m-d H:i:s') : null,
        ];
    }
}