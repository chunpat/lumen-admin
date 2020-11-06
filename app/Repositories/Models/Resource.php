<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    /**
     * @var string
     */
    protected $table = 'resource';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
