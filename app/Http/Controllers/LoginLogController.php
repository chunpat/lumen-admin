<?php

namespace App\Http\Controllers;

use App\Services\LoginLogService;
use Illuminate\Http\Request;

class LoginLogController extends Controller
{
    /**
    * @var LoginLogService
    */
    private $loginLogService;

    /**
     * LoginLogController constructor.
     *
     * @param LoginLogService   $loginLogService
     */
    public function __construct(LoginLogService $loginLogService)
    {
        $this->loginLogService = $loginLogService;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @api               {get} loginLogs 登录日志
     * @apiName           get_loginLogs
     * @apiGroup          Log
     *
     * @apiSuccess {String} id   ID
     * @apiSuccess {String} name   路由名称
     * @apiSuccess {String} ip     ip地址
     * @apiSuccess {String} location  位置
     * @apiSuccess {String} browser   浏览器核心
     * @apiSuccess {String} platform   操作系统
     * @apiSuccess {Integer} status   状态 0 失败 1成功
     * @apiSuccess {String} created_at
     *
     * @apiSuccessExample Success-Response:
     *  {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"data":[{"id":11,"name":"chunpat","ip":"127.0.0.1","location":"-","browser":"Chrome 86.0.4240.111","platform":"OS X 10_14_4","status":0,"created_at":"2020-11-04 09:55:48"},{"id":12,"name":"chunpat","ip":"127.0.0.1","location":"-","browser":"Chrome 86.0.4240.111","platform":"OS X 10_14_4","status":0,"created_at":"2020-11-04 09:55:48"},{"id":13,"name":"chunpat","ip":"127.0.0.1","location":"-","browser":"Chrome 86.0.4240.111","platform":"OS X 10_14_4","status":0,"created_at":"2020-11-04 09:55:49"},{"id":14,"name":"chunpat","ip":"127.0.0.1","location":"-","browser":"Chrome 86.0.4240.111","platform":"OS X 10_14_4","status":0,"created_at":"2020-11-04 09:55:49"},{"id":15,"name":"chunpat","ip":"127.0.0.1","location":"-","browser":"Chrome 86.0.4240.111","platform":"OS X 10_14_4","status":0,"created_at":"2020-11-04 09:55:49"}],"meta":{"pagination":{"total":5,"count":5,"per_page":10,"current_page":1,"total_pages":1,"links":{}}}}}
     *
     * @apiUse            FailResponse
     *
     */
    public function index(Request $request)
    {
        $loginLogs = $this->loginLogService->handleList($request);
        return $this->response->success($loginLogs);
    }
}
