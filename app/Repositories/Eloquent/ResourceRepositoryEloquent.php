<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\ResourceRepository;
use App\Repositories\Models\Resource;
use App\Repositories\Validators\ResourceValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class ResourceRepositoryEloquent extends BaseRepository implements ResourceRepository
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
        return Resource::class;
    }

    /**
     * Specify Validator class name.
     *
     * @return mixed
     */
    public function validator()
    {
       return ResourceValidator::class;
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
    public function searchResourcesByPage()
    {
        return $this->paginate(10);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function searchResourceBy($id)
    {
        return $this->find($id);
    }
}