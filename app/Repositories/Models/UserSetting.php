<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_setting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'theme_color',
        'open_tags_view',
        'fixed_header',
        'sidebar_logo',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
