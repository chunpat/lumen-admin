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
use App\Repositories\Enums\StatusEnum;
use App\Repositories\Models\User;
use App\Repositories\Validators\UserValidator;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
        'email', // Default Condition "="
    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return User::class;
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
     * Date: 2020/10/16
     * @return mixed
     */
    public function searchUsersByPage()
    {
        return $this->model->with(['userRoles'=>function($q){
            $q->select(['id','role_id','user_id']);
        }])->paginate(10);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     *
     * @param $id
     *
     * @return mixed
     */
    public function searchUserBy($id)
    {
        return $this->model->with('userRoles')->find($id);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     *
     * @param $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function insertUser($attributes)
    {
        $this->model->name = $attributes['name'];
        $this->model->email = $attributes['email'];
        $this->model->password = Hash::make($attributes['password']);
        $this->model->nickname = $attributes['nickname'];
        $this->model->phone = $attributes['phone'];
        $this->model->avatar = $attributes['avatar'] ?? '';
        $this->model->gender = $attributes['gender'] ?? 3;
        $this->model->introduction = $attributes['introduction'] ?? '';
        $this->model->status = $attributes['status'] ?? 0;

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
    public function updateUser($attributes)
    {
        $id = $attributes['id'];
        unset($attributes['id']);
        $this->model = User::findOrFail($id);
//        $this->model->password = Hash::make($attributes['password']);
        $this->model->nickname = $attributes['nickname'];
        $this->model->avatar = $attributes['avatar'] ?? '';
        $this->model->introduction = $attributes['introduction'] ?? '';
        $this->model->status = $attributes['status'] ?? 0;
        $this->model->gender = $attributes['gender'] ?? 3;
        $this->model->save();
        return $this->model;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/11/5
     * @param $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateUserPassword($attributes)
    {
        $id = $attributes['id'];
        unset($attributes['id']);
        $this->model = User::findOrFail($id);
        $this->model->password = Hash::make($attributes['password']);
        $this->model->save();
        return $this->model;
    }
    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getDetail($id)
    {
        return $this->model->with(['roles'=>function($q){
            $q->with(['permissions']);
            $q->where('status',StatusEnum::AVAILABLE);
        }])->findOrFail($id);
    }
}
