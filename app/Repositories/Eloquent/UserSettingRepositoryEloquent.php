<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\UserSettingRepository;
use App\Repositories\Models\UserSetting;
use App\Repositories\Validators\UserSettingValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserSettingRepositoryEloquent extends BaseRepository implements UserSettingRepository
{
    protected $fieldSearchable = [

    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return UserSetting::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
       return UserSettingValidator::class;
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
     * @return mixed
     */
    public function searchUserSettingsByPage()
    {
        return $this->paginate(10);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function searchUserSettingBy($id)
    {
        return $this->find($id);
    }
}