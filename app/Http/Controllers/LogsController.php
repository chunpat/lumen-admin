<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2020/9/22
 * Time: 17:14
 */

namespace App\Http\Controllers;


use App\Services\LogsService;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * @var LogsService
     */
    private $logsService;

    public function __construct(LogsService $logsService)
    {
        $this->logsService = $logsService;

//        $this->middleware('auth:api', ['except' => ['store', 'show', 'index']]);
    }


    public function list(Request $request){
        $logs = $this->logsService->handleList($request);

        return $this->response->success($logs);
    }
}