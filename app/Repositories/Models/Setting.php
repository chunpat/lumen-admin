<?php

namespace App\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * @var string
     */
    protected $table = 'setting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'title',
        'type',
        'value',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];
}
