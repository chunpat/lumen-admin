<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\RoleRepository;
use App\Repositories\Models\Role;
use App\Repositories\Models\RolePermission;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RoleRepositoryEloquent.
 */
class RolePermissionRepositoryEloquent extends BaseRepository implements RoleRepository
{
    protected $fieldSearchable = [
        'role_id' => 'like',
        'permission_id' => 'like', // Default Condition "="
    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return RolePermission::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
    }

    /**
     * Boot up the repository, pushing criteria.
     *
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function insert($attributes)
    {
        $this->model->name = $attributes['name'];
        $this->model->en = $attributes['en'];

        $this->model->saveOrFail();

        return $this->model;
    }




}
