<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2020/10/14
 * Time: 13:42
 */

namespace App\Repositories\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    /**
     * @author: chunpat@163.com
     * Date: 2020/10/16
     * @param array $data
     *
     * @return bool
     */
    public function createAll(Array $data)
    {
        $rs = DB::table($this->getTable())->insert($data);
        return $rs;
    }

}