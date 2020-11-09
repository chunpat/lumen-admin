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
     * @apiSuccess {String} desc   描述
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
        $fp = popen('top -b -n 2 | grep -E "(Cpu|Mem)"',"r");//获取某一时刻系统cpu和内存使用情况
        $rs = "";
        while(!feof($fp)){
            $rs .= fread($fp,1024);
        }
        pclose($fp);
        echo $rs.'<br>';
        preg_match_all("/Cpu.*us\,/", $rs,$cpus);
        var_dump($cpus[1]);
        echo '<br>';
        preg_match('/(\d|\.)+/', $cpus[1], $cpu); //cpu使用百分比
        var_dump($cpu);
        echo '<br>';
        preg_match_all('/ \d+ used/', $rs,$cmems);
        var_dump($cmems[3]);
        echo '<br>';
        preg_match('/\d+/', $cmems[3],$cmem); //内存使用量 k
        var_dump($cmem);
        $log = "$cpu[0]--$cmem[0],\r\n";
        echo $log;
        $logres = file_put_contents('./yali.log',$log,FILE_APPEND);
        exit;
        $loginLogs = $this->loginLogService->handleList($request);
        return $this->response->success($loginLogs);
    }
}
