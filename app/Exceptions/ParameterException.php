<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2020/9/22
 * Time: 11:12
 */

namespace App\Exceptions;


use Illuminate\Http\Response;

class ParameterException extends ApiHttpException
{
    public function __construct($code = Response::HTTP_BAD_REQUEST, $message = "", \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}