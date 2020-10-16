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
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RoleRepositoryEloquent.
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'en' => 'like', // Default Condition "="
    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
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

    public function searchRoleByPage()
    {
        return $this->with('permissions')->paginate(10);
    }

    public function searchRoleBy($id)
    {
        return $this->find($id);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function insertRole($attributes)
    {
        $this->model->name = $attributes['name'];
        $this->model->en = $attributes['en'];

        $this->model->saveOrFail();

        return $this->model;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateRole($attributes)
    {
        $id = $attributes['id'];
        unset($attributes['id']);
        $this->model = Role::findOrFail($id);
        $this->model->name = $attributes['name'];
        $this->model->en = $attributes['en'];
        $this->model->save();
        return $this->model;
    }
}
