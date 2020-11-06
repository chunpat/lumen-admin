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

use App\Repositories\Criteria\PermissionCriteria;
use App\Repositories\Eloquent\PermissionRepositoryEloquent;
use App\Repositories\Presenters\PermissionPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionService
 * @package App\Services
 */
class PermissionService
{
    /**
     * @var PermissionRepositoryEloquent
     */
    private $repository;

    /**
     * UserService constructor.
     *
     * @param PermissionRepositoryEloquent $repository
     */
    public function __construct(PermissionRepositoryEloquent $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/17
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function handleList(Request $request)
    {
        $this->repository->pushCriteria(new PermissionCriteria($request));
        $this->repository->setPresenter(PermissionPresenter::class);

        return $this->repository->searchByPage(20);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     * @param array $permissionIds
     *
     * @return array
     */
    public function menus(array $permissionIds)
    {
        $this->repository->setPresenter(PermissionPresenter::class);
        $permissions = $this->repository->getByPermissionIds($permissionIds);

        $newPermissions = [];
        //数据处理
        foreach ($permissions as $permission){
            if(isset($newPermissions[$permission->parent_id])){
                $newPermissions[$permission->parent_id][] = $permission->toArray();
            }else{
                $newPermissions[$permission->parent_id] = [];
                $newPermissions[$permission->parent_id][] = $permission->toArray();
            }
        }

        $treePermissions = [];
        self::getTreeByParentPermissionId($newPermissions, $treePermissions, 0);
        return $treePermissions;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/17
     *
     * @param array $roleIds
     *
     * @return array
     */
    public function getPermissionIdsByRoleIds(array $roleIds)
    {
        $permissions = $this->repository->getPermissionIdsByRoleIds($roleIds);
        $newPermissions = [];

        //数据处理
        foreach ($permissions as $permission){
            if(isset($newPermissions[$permission->parent_id])){
                $newPermissions[$permission->parent_id][] = $permission->toArray();
            }else{
                $newPermissions[$permission->parent_id] = [];
                $newPermissions[$permission->parent_id][] = $permission->toArray();
            }
        }

        $treePermissions = [];
        self::getTreeByParentPermissionId($newPermissions, $treePermissions, 0);
        return $treePermissions;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     * @param array $newPermissions
     * @param array $treePermissions
     * @param int   $parentPermissionId
     */
    protected static function getTreeByParentPermissionId(array $newPermissions,array &$treePermissions,int $parentPermissionId = 0)
    {
        if(isset($newPermissions[$parentPermissionId])){
            $treePermissions = $newPermissions[$parentPermissionId];
            foreach ($treePermissions as &$newPermission){
                $newPermission['children'] = [];
                self::getTreeByParentPermissionId($newPermissions,$newPermission['children'],$newPermission['id']);
            }
        }
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/17
     *
     * @param $id
     *
     * @return mixed
     */
    public function handleProfile($id)
    {
        $this->repository->setPresenter(PermissionPresenter::class);

        return $this->repository->searchUserBy($id);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     * @param Request $request
     *
     * @return mixed
     */
    public function handleCreate(Request $request)
    {
        $permission = DB::transaction(function () use ($request) {
            $permissionResource = $this->repository->create($request->all());
            return $this->updatePaths($permissionResource->id);
        });
        return $permission;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/17
     *
     * @param int $id
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updatePaths(int $id)
    {
        $permission = $this->repository->getParents($id);
        $pathArray = [$permission->id];
        self::getPathIds($permission,$pathArray);
        sort($pathArray);
        $pathIds = '';
        foreach ($pathArray as $path){
            $pathIds = $pathIds . '/' . $path;
        }
        $attributes['paths'] = $pathIds;
        return $this->repository->update($attributes,$id);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/17
     *
     * @param       $permission
     * @param array $pathIdArray
     */
    protected static function getPathIds($permission,array &$pathIdArray = []){
        if($permission->parent){
            $pathIdArray[] = $permission->parent->id;
            self::getPathIds($permission->parent,$pathIdArray);
        }
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
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
