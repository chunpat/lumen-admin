<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\SettingRepository;
use App\Repositories\Models\Setting;
use App\Repositories\Validators\SettingValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class SettingRepositoryEloquent extends BaseRepository implements SettingRepository
{
    protected $fieldSearchable = [
        // 'name' => 'like', Default Condition "="
    ];

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Setting::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
       return SettingValidator::class;
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
    public function searchSettings()
    {
        return $this->get();
    }

    /**
     * @return mixed
     */
    public function searchSettingsByPage()
    {
        return $this->paginate(10);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function searchSettingBy($id)
    {
        return $this->find($id);
    }
}