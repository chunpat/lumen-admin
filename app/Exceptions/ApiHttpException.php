<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2020/9/22
 * Time: 10:49
 */

namespace App\Exceptions;


use Illuminate\Http\Response;

class ApiHttpException extends \Exception
{
    public function __construct($message = "", $code = Response::HTTP_BAD_REQUEST, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}