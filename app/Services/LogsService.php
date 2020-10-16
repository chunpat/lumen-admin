<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2020/9/22
 * Time: 17:15
 */

namespace App\Services;


use App\Contracts\Repositories\LogsRepository;
use App\Repositories\Criteria\LogsCriteria;
use App\Repositories\Eloquent\LogsRepositoryEloquent;
use App\Repositories\Presenters\LogsPresenter;
use Illuminate\Http\Request;

class LogsService
{
    private $repository;

    /**
     * UserService constructor.
     *
     * @param LogsRepositoryEloquent $repository
     */
    public function __construct(LogsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @author: zzhpeng
     * Date: 2020/9/22
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function handleList(Request $request)
    {
        $this->repository->pushCriteria(new LogsCriteria($request));
        $this->repository->setPresenter(LogsPresenter::class);

        return $this->repository->searchUsersByPage();
    }

//    public function handleProfile($id)
//    {
//        $this->repository->setPresenter(UserPresenter::class);
//
//        return $this->repository->searchUserBy($id);
//    }
//
//    public function handleRegistration(Request $request)
//    {
//        return $this->repository->insertUser($request->all());
//    }

}