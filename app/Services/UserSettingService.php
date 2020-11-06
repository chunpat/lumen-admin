<?php

namespace App\Services;

use App\Contracts\Repositories\UserSettingRepository;
use App\Exceptions\ParameterException;
use App\Repositories\Criteria\UserSettingCriteria;
use App\Repositories\Eloquent\UserSettingRepositoryEloquent;
use App\Repositories\Presenters\UserSettingPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingService
{
    /**
     * @var UserSettingRepositoryEloquent
     */
    private $userSettingRepository;

    /**
     * UserSettingService constructor.
     *
     * @param UserSettingRepositoryEloquent $userSettingRepositoryEloquent
     */
    public function __construct(UserSettingRepositoryEloquent $userSettingRepositoryEloquent)
    {
        $this->userSettingRepository = $userSettingRepositoryEloquent;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function handleList(Request $request)
    {
        $this->userSettingRepository->pushCriteria(new UserSettingCriteria($request));
        $this->userSettingRepository->setPresenter(UserSettingPresenter::class);

        return $this->userSettingRepository->searchUserSettingsByPage();
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handleProfile($id)
    {
        $this->userSettingRepository->setPresenter(UserSettingPresenter::class);
        return $this->userSettingRepository->searchUserSettingBy($id);
    }

    /**
     * @param array $array
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handleStore(array $array)
    {
        $userSetting = $this->userSettingRepository->create($array);
        return $userSetting;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/11/6
     * @param Request $request
     *
     * @return mixed
     * @throws ParameterException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handleUpdate(Request $request)
    {
        $userSetting = $this->userSettingRepository->findOrFail($request->get('id'));
        if($userSetting->user_id != Auth::id()){
            throw new ParameterException(400004);
        }
        $userSetting = $this->userSettingRepository->update($request->all(),$request->get('id'));
        return $userSetting;
    }
}
