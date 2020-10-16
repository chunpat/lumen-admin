<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2020/9/22
 * Time: 16:41
 */

namespace App\Repositories\Eloquent;


use App\Contracts\Repositories\LogsRepository;
use App\Repositories\Models\Logs;
use Prettus\Repository\Eloquent\BaseRepository;

class LogsRepositoryEloquent extends BaseRepository implements LogsRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return Logs::class;
    }

    /**
     * @author: zzhpeng
     * Date: 2020/9/22
     * @return mixed
     */
    public function searchUsersByPage()
    {
        return $this->paginate(3);
    }

}