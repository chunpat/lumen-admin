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
use Illuminate\Support\Facades\DB;

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
        return $this->repository->searchRoleByPage();
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
        return DB::transaction(function()use($request){
            $role = $this->repository->create($request->all());
            $menuIds = $request->get('menu_ids');
            $insertData = [];
            foreach ($menuIds as $menuId){
                $insertData[] = [
                    'permission_id'=>$menuId,
                    'role_id'=>$role->id
                ];
            }
            //insert new data
            if($insertData) {
                $this->rolePermissionRepository->createAll($insertData);
            }
            return $role;
        });
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param Request $request
     *
     * @return mixed
     */
    public function handleUpdate(Request $request)
    {
        return DB::transaction(function()use($request){
            $role = $this->repository->searchRoleBy($request->get('id'));
            $oldPermissionIds = [];

            foreach ($role->rolePermissions as $rolePermission){
                $oldPermissionIds[] = $rolePermission->id;
            }

            $newPermissionIds = $request->get('menu_ids');
            $keepPermissionIds = array_intersect($oldPermissionIds,$newPermissionIds);
            $preparePermissionId = array_diff($newPermissionIds,$oldPermissionIds);
            //delete
            $this->rolePermissionRepository->batchDeleteNotInIds($keepPermissionIds,$role->id);
            $insertData = [];
            foreach ($preparePermissionId as $menuId){
                $insertData[] = [
                    'permission_id'=>$menuId,
                    'role_id'=>$role->id
                ];
            }
            //insert new data
            if($insertData){
               $this->rolePermissionRepository->createAll($insertData);
            }
            return $this->repository->update($request->all(),$request->get('id'));
        });
    }
}
