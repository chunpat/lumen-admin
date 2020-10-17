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
 * Class Role
 * @package App\Repositories\Models
 */
class Role extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'role';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'en', 'remark','sort','status'
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
     * Date: 2020/10/16
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(){
        return $this->belongsToMany('App\Repositories\Models\Permission','App\Repositories\Models\RolePermission','role_id','permission_id');
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/17
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rolePermissions(){
        return $this->hasMany('App\Repositories\Models\RolePermission','role_id','id');
    }
}

