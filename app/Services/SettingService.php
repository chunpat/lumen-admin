<?php

namespace App\Services;

use App\Contracts\Repositories\SettingRepository;
use App\Exceptions\ParameterException;
use App\Repositories\Criteria\SettingCriteria;
use App\Repositories\Eloquent\SettingRepositoryEloquent;
use App\Repositories\Presenters\SettingPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class SettingService
{
    /**
     * @var SettingRepositoryEloquent
     */
    private $settingRepository;

    /**
     * SettingService constructor.
     *
     * @param SettingRepositoryEloquent $settingRepositoryEloquent
     */
    public function __construct(SettingRepositoryEloquent $settingRepositoryEloquent)
    {
        $this->settingRepository = $settingRepositoryEloquent;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function handleList(Request $request)
    {
        $this->settingRepository->pushCriteria(new SettingCriteria($request));
        $this->settingRepository->setPresenter(SettingPresenter::class);

        return $this->settingRepository->searchSettings();
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handleProfile($id)
    {
        $this->settingRepository->setPresenter(SettingPresenter::class);
        return $this->settingRepository->searchSettingBy($id);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handleStore(Request $request)
    {
        $setting = $this->settingRepository->create($request->all());
        return $setting;
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/11/6
     * @param array $array
     *
     * @return bool
     */
    public function handleUpdateAll(array $array)
    {
        DB::transaction(function() use($array){
            foreach ($array as $batch) {
                if(!isset($batch['id'])){
                    throw new ParameterException(400001);
                }
                $this->settingRepository->update($batch,$batch['id']);
            }
        });
        return true;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handleUpdate(Request $request)
    {
        return $this->settingRepository->update($request->all(),$request->get('id'));
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/11/5
     * @param Request $request
     *
     * @return mixed
     * @throws ParameterException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handleUpdateUser(Request $request)
    {
        $setting = $this->settingRepository->findOrFail($request->get('id'));
        if($setting->user_id != Auth::id()){
            throw new ParameterException(40004);
        }

        return $this->settingRepository->update($request->all(),$request->get('id'));
    }
}
