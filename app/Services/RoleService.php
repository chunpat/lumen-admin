<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services;

use App\Contracts\Repositories\RoleRepository;
use App\Repositories\Criteria\RoleCriteria;
use App\Repositories\Eloquent\RolePermissionRepositoryEloquent;
use App\Repositories\Eloquent\RoleRepositoryEloquent;
use App\Repositories\Presenters\RolePresenter;
use Illuminate\Http\Request;

/**
 * Class RoleService
 * @package App\Services
 */
class RoleService
{
    /**
     * @var RoleRepository|RoleRepositoryEloquent
     */
    private $repository;


    /**
     * @var RolePermissionRepositoryEloquent
     */
    private $rolePermissionRepository;

    /**
     * RoleService constructor.
     *
     * @param RoleRepositoryEloquent $repository
     * @param RolePermissionRepositoryEloquent $rolePermissionRepository
     */
    public function __construct(RoleRepositoryEloquent $repository,RolePermissionRepositoryEloquent $rolePermissionRepository)
    {
        $this->repository = $repository;
        $this->rolePermissionRepository = $rolePermissionRepository;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function handleList(Request $request)
    {
        $this->repository->pushCriteria(new RoleCriteria($request));
//        $this->repository->setPresenter(RolePresenter::class);
        $data = $this->repository->searchRoleByPage()->toArray();

        foreach ($data['data'] as &$role){
            $menuIds = [];
            foreach ($role['permissions'] as $permission){
                $menuIds[] = $permission['id'];
            }
            $role['menu_ids'] = array_unique($menuIds);
            unset( $role['permissions']);
            unset( $role['deleted_at']);

        }
        return $data;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     *
     * @param $id
     *
     * @return mixed
     */
    public function handleProfile($id)
    {
        $this->repository->setPresenter(RolePresenter::class);

        return $this->repository->searchRoleBy($id);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     *
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function handleRegistration(Request $request)
    {
        return $this->repository->create($request->all());
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handleUpdate(Request $request)
    {
        return $this->repository->update($request->all(),$request->get('id'));
    }
}
