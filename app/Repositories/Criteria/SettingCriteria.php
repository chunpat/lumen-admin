<?php

namespace App\Repositories\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class SettingCriteria implements CriteriaInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        // this is a Example
        if ($this->request->filled('key')) {
            $model = $model->where('key', '=', $this->request->get('key'));
        }
        if ($this->request->filled('type')) {
            $model = $model->where('type', '=', $this->request->get('type'));
        }

        return $model;
    }
}
