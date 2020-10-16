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
use App\Repositories\Presenters\UserPresenter;
use Illuminate\Http\Request;

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
     * UserService constructor.
     *
     * @param UserRepositoryEloquent $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
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
        return $this->repository->insertUser($request->all());
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handleUpdate(Request $request)
    {
        return $this->repository->updateUser($request->all());
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
