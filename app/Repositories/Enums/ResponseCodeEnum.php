<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories\Enums;

use App\Contracts\Enums\LocalizedEnumContract;
use App\Support\Enum\Enum;
use Illuminate\Http\Response as HttpResponse;
use ReflectionClass;
use ReflectionException;

class ResponseCodeEnum extends Enum implements LocalizedEnumContract
{
    // 定制/覆盖 HTTP 协议状态码
    const HTTP_OK = 200;

    // 业务操作正确码：1xx、2xx、3xx 开头，后拼接 3 位
    // 200 + 001 => 200001，也就是有 001 ~ 999 个编号可以用来表示业务成功的情况，当然你可以根据实际需求继续增加位数，但必须要求是 200 开头
    // 举个栗子：你可以定义 001 ~ 099 表示系统状态；100 ~ 199 表示授权业务；200 ~ 299 表示用户业务...
    const SERVICE_REGISTER_SUCCESS = 200101;
    const SERVICE_LOGIN_SUCCESS = 200102;

    // 客户端错误码：400 ~ 499 开头，后拼接 3 位
    const CLIENT_PARAMETER_ERROR = 400001;
    const CLIENT_CREATED_ERROR = 400002;
    const CLIENT_DELETED_ERROR = 400003;
    const CLIENT_PARAMETER_AUTH_ERROR = 400004;



    //使用示范
    const CLIENT_TEST_ERROR = 400009;

    // 服务端操作错误码：500 ~ 599 开头，后拼接 3 位
    const SYSTEM_ERROR = 500001;
    const SYSTEM_UNAVAILABLE = 500002;

    // 业务操作错误码（外部服务或内部服务调用...）
    const SERVICE_REGISTER_ERROR = 500101;
    const SERVICE_LOGIN_ERROR = 500102;

    /**
     * Get the description for an enum value.
     *
     * @param  mixed  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        return static::getLocalizedDescription($value) ?? HttpResponse::$statusTexts[$value];
    }

    /**
     * Get all of the constants defined on the class.
     *
     * @return array
     * @throws ReflectionException
     */
    protected static function getConstants(): array
    {
        $calledClass = get_called_class();
        if (! array_key_exists($calledClass, static::$cache)) {
            $reflect = new ReflectionClass($calledClass);
            static::$cache[$calledClass] = array_merge(self::getHttpConstants(), $reflect->getConstants());
        }

        return static::$cache[$calledClass];
    }

    protected static function getHttpConstants(): array
    {
        $reflect = new ReflectionClass(HttpResponse::class);

        return $reflect->getConstants();
    }
}
