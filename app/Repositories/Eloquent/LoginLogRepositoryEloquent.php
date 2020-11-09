<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\LoginLogRepository;
use App\Repositories\Models\LoginLog;
use App\Repositories\Validators\LoginLogValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class LoginLogRepositoryEloquent extends BaseRepository implements LoginLogRepository
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
        return LoginLog::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
       return LoginLogValidator::class;
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
    public function searchLoginLogsByPage()
    {
        return $this->orderBy('id','desc')->paginate(10);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function searchLoginLogBy($id)
    {
        return $this->find($id);
    }
}