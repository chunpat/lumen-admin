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

/**
 * Class Permission
 * @package App\Repositories\Models
 */
/**
 * Class Permission
 * @package App\Repositories\Models
 */
class Permission extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'permission';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'type',
        'icon',
        'path',
        'component',
        'is_redirect',
        'is_affix',
        'is_always_show',
        'is_hidden',
        'is_no_cache',
        'parent_id',
        'sort',
        'paths',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(){
        return $this->hasMany('App\Repositories\Models\Permission','parent_id','id');
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(){
        return $this->belongsTo('App\Repositories\Models\Permission','parent_id','id');
    }
}
