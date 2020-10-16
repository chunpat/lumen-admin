<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2020/10/14
 * Time: 13:42
 */

namespace App\Repositories\Models;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}