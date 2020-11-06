<?php

namespace App\Repositories\Transformers;

use App\Repositories\Models\UserSetting;
use League\Fractal\TransformerAbstract;

class UserSettingTransformer extends TransformerAbstract
{
   /**
    * Prepare data to present.
    *
    * @param UserSetting $userSetting
    * @return array
    */
    public function transform(UserSetting $userSetting)
    {
        return [
            'id' => $userSetting->id,
            'theme_color' => $userSetting->theme_color,
            'open_tags_view' => $userSetting->open_tags_view,
            'fixed_header' => $userSetting->fixed_header,
            'sidebar_logo' => $userSetting->sidebar_logo,
            'created_at' => $userSetting->created_at ? $userSetting->created_at->format('Y-m-d H:i:s') : null,
        ];
    }
}