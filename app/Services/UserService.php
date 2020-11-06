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

use App\Contracts\Repositories\UserRepository;
use App\Repositories\Criteria\UserCriteria;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Repositories\Eloquent\UserRoleRepositoryEloquent;
use App\Repositories\Models\UserRole;
use App\Repositories\Presenters\UserPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @var UserRepository|UserRepositoryEloquent
     */
    private $repository;

    /**
     * @var UserRepository|UserRepositoryEloquent
     */
    private $userRoleRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository             $repository
     * @param UserRoleRepositoryEloquent $userRoleRepository
     */
    public function __construct(UserRepository $repository, UserRoleRepositoryEloquent $userRoleRepository)
    {
        $this->repository = $repository;
        $this->userRoleRepository = $userRoleRepository;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function handleList(Request $request)
    {
        $this->repository->pushCriteria(new UserCriteria($request));
        $this->repository->setPresenter(UserPresenter::class);

        return $this->repository->searchUsersByPage();
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     *
     * @param $id
     *
     * @return mixed
     */
    public function handleProfile($id)
    {
        $this->repository->setPresenter(UserPresenter::class);
        return $this->repository->searchUserBy($id);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     *
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function handleRegistration(Request $request)
    {
        $user = DB::transaction(function () use ($request) {
            $user = $this->repository->insertUser($request->all());
            $roleIds = $request->get('role_ids');
            $insertData = [];
            foreach ($roleIds as $roleId) {
                $insertData[] = [
                    'role_id' => $roleId,
                    'user_id' => $user->id,
                ];
            }
            //userRole insert
            if ($insertData) $this->userRoleRepository->createAll($insertData);
            return $user;
        });

        return $user;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     *
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handleUpdate(Request $request)
    {
        $user = DB::transaction(function () use ($request) {
            $user = $this->repository->searchUserBy($request->get('id'));
            $oldRoleIds = [];
            foreach ($user->userRoles as $userRole) {
                $oldRoleIds[] = $userRole->role_id;
            }

            $newRoleIds = $request->get('role_ids');
            $keepRoleIds = array_intersect($oldRoleIds, $newRoleIds);
            $prepRoleIds = array_diff($newRoleIds, $oldRoleIds);

            //delete
            $this->userRoleRepository->batchDeleteNotInIds($keepRoleIds, $user->id);
            $insertData = [];
            foreach ($prepRoleIds as $roleId) {
                $insertData[] = [
                    'user_id' => $user->id,
                    'role_id' => $roleId
                ];
            }

            //insert new data
            if ($insertData) {
                $this->userRoleRepository->createAll($insertData);
            }
            return $this->repository->updateUser($request->all());
        });
        return $user;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/11/5
     * @param Request $request
     *
     * @return mixed
     */
    public function handleUpdatePassword(Request $request)
    {
        $user = $this->repository->updateUserPassword($request);
        return $user;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getDetailByAuth()
    {
        return $this->repository->getDetail(auth()->id());
    }
}
