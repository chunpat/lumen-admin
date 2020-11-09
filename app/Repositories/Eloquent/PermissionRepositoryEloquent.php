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
use App\Repositories\Models\Permission;
use App\Repositories\Models\Role;
use Illuminate\Support\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 */
class PermissionRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
        'title' => 'like',
        'email', // Default Condition "="
    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
//        return PermissionValidator::class;
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
     * Date: 2020/10/15
     *
     * @param $limit
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchByPage($limit)
    {
        return $this->model->with(['children'=>function($q){
            $q->with(['children'=>function($q){
                $q->with('children')->orderByDesc('sort');
            }])->orderByDesc('sort');
        }])->orderByDesc('sort')->where('parent_id',0)->paginate($limit);
    }

    public function getByPermissionIds(array $permissionIds = [],array $field = ['*'])
    {
        $permissions = $this->model->whereIn('id',$permissionIds)->select($field)->orderBy('sort','desc')->get();
        return $permissions;
    }

    public function getPermissionIdsByRoleIds(array $permissionIds = [],array $field = ['*'])
    {
        $permissions = $this->model->whereIn('id',$permissionIds)->select($field)->get();
        return $permissions;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     *
     * @param $id
     *
     * @return mixed
     */
    public function getParents($id)
    {
        return $this->model->with(['parent'=>function($q){
            $q->with(['parent'=>function($q){
                $q->with('parent')->select(['id','parent_id']);
            }])->select(['id','parent_id']);
        }])->select(['id','parent_id'])->where('id',$id)->first();
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     *
     * @param $id
     *
     * @return mixed
     */
    public function searchUserBy($id)
    {
        return $this->find($id);
    }

//    public function insert($attributes)
//    {
//        $this->model->name = $attributes['name'];
//        $this->model->title = $attributes['title'];
//        $this->model->icon = $attributes['icon'];
//        $this->model->path = $attributes['path'];
//        $this->model->paths = $attributes['paths'];
//        $this->model->component = $attributes['component'];
//        $this->model->redirect = $attributes['redirect'];
//        $this->model->always_show = $attributes['always_show'];
//        $this->model->hidden = $attributes['hidden'];
//        $this->model->no_cache = $attributes['no_cache'];
//        $this->model->parent_id = $attributes['parent_id'];
//
//        $this->model->saveOrFail();
//
//        return $this->model;
//    }

//    /**
//     * @author: chunpat@163.com
//     * Date: 2020/10/14
//     * @param $attributes
//     *
//     * @return \Illuminate\Database\Eloquent\Model
//     */
//    public function update($attributes)
//    {
//        $id = $attributes['id'];
//        unset($attributes['id']);
//        $this->model = Permission::findOrFail($id);
//        $this->model->name = $attributes['name'];
//        $this->model->title = $attributes['title'];
//        $this->model->icon = $attributes['icon'];
//        $this->model->path = $attributes['path'];
//        $this->model->paths = $attributes['paths'];
//        $this->model->component = $attributes['component'];
//        $this->model->redirect = $attributes['redirect'];
//        $this->model->always_show = $attributes['always_show'];
//        $this->model->hidden = $attributes['hidden'];
//        $this->model->no_cache = $attributes['no_cache'];
//        $this->model->parent_id = $attributes['parent_id'];
//        $this->model->save();
//        return $this->model;
//    }
}
