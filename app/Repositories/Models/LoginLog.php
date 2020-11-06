<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    /**
     * @var string
     */
    protected $table = 'login_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'ip',
        'location',
        'browser',
        'platform',
        'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
