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

use App\Contracts\Repositories\UserRepository;
use App\Repositories\Models\User;
use App\Repositories\Models\UserRole;
use App\Repositories\Validators\UserValidator;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 */
class UserRoleRepositoryEloquent extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return UserRole::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
        return UserValidator::class;
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
     * Date: 2020/10/17
     *
     * @param array $roleIds
     * @param int   $userId
     *
     * @return mixed
     */
    public function batchDeleteNotInIds(array $roleIds, int $userId)
    {
        return $this->model->where('user_id', $userId)->whereNotIn('role_id', $roleIds)->delete();
    }
}
