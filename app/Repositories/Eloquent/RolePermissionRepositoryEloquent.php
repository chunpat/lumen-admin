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
use App\Repositories\Models\RolePermission;
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

    public function batchDeleteNotInIds(array $permissionIds,int $roleId)
    {
        return $this->model->where('role_id',$roleId)->whereNotIn('permission_id',$permissionIds)->delete();
    }

}
