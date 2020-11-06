<?php

namespace App\Services;

use App\Contracts\Repositories\ResourceRepository;
use App\Repositories\Criteria\ResourceCriteria;
use App\Repositories\Eloquent\ResourceRepositoryEloquent;
use App\Repositories\Presenters\ResourcePresenter;
use Illuminate\Http\Request;

class ResourceService
{
    /**
     * @var ResourceRepositoryEloquent
     */
    private $resourceRepository;

    /**
     * ResourceService constructor.
     *
     * @param ResourceRepositoryEloquent $resourceRepositoryEloquent
     */
    public function __construct(ResourceRepositoryEloquent $resourceRepositoryEloquent)
    {
        $this->resourceRepository = $resourceRepositoryEloquent;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function handleList(Request $request)
    {
        $this->resourceRepository->pushCriteria(new ResourceCriteria($request));
        $this->resourceRepository->setPresenter(ResourcePresenter::class);

        return $this->resourceRepository->searchResourcesByPage();
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function handleProfile($id)
    {
        $this->resourceRepository->setPresenter(ResourcePresenter::class);
        return $this->resourceRepository->searchResourceBy($id);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handleStore(Request $request)
    {
        $resource = $this->resourceRepository->create($request->all());
        return $resource;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handleUpdate(Request $request)
    {
        $resource = $this->resourceRepository->update($request->all(),$request->get('id'));
        return $resource;
    }
}
