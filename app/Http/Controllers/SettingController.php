<?php

namespace App\Http\Controllers;

use App\Exceptions\ParameterException;
use App\Http\Resources\SettingResource;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
    * @var SettingService
    */
    private $settingService;

    /**
     * SettingController constructor.
     *
     * @param SettingService   $settingService
     */
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
//        $this->middleware('refreshToken:api', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @api               {get} settings 获取设置
     * @apiName           get_settings
     * @apiGroup          Setting
     *
     * @apiParam {String} type   类型  system：系统设置
     * @apiParam {String} key   关键字
     *
     * @apiSuccess {String} id   ID
     * @apiSuccess {String} key   菜单标题
     * @apiSuccess {String} title   路由名称
     * @apiSuccess {String} type   类型  system：系统设置
     * @apiSuccess {String} value   值
     * @apiSuccess {String} created_at
     *
     * @apiSuccessExample Success-Response:
     *  {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"data":[{"id":1,"key":"systemTitle","title":"\u7cfb\u7edf\u540d\u79f0","type":"system","value":"onehour-admin\u7ba1\u7406\u7cfb\u7edf","created_at":null},{"id":2,"key":"systemLogo","title":"\u7cfb\u7edflogo","type":"system","value":"onehour-admin","created_at":null}]}}
     *
     * @apiUse            FailResponse
     */
    public function index(Request $request)
    {
        $settings = $this->settingService->handleList($request);
        return $this->response->success($settings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @api               {post} setting 添加设置
     * @apiName           post_setting
     * @apiGroup          Setting
     *
     * @apiParam {String} type   类型  system：系统设置
     * @apiParam {String} key   关键字
     * @apiParam {String} title   中文名字
     * @apiParam {String} value   值
     *
     * @apiSuccess {String} id   ID
     * @apiSuccess {String} key   菜单标题
     * @apiSuccess {String} title   路由名称
     * @apiSuccess {String} type   类型  system：系统设置
     * @apiSuccess {String} value   值
     * @apiSuccess {String} created_at
     *
     * @apiUse            FailResponse
     */
    public function store(Request $request)
    {
        $setting = $this->settingService->handleStore($request);
        return $this->response->created(new SettingResource($setting));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function show($id)
    {
        $setting = $this->settingService->handleProfile($id);
        return $this->response->success($setting);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @api               {put} setting 更新设置
     * @apiName           put_setting
     * @apiGroup          Setting
     *
     * @apiParam {Integer} id    ID
     * @apiParam {String} type   类型  system：系统设置
     * @apiParam {String} key   关键字
     * @apiParam {String} title   中文名字
     * @apiParam {String} value   值
     *
     * @apiSuccess {String} id   ID
     * @apiSuccess {String} key   菜单标题
     * @apiSuccess {String} title   路由名称
     * @apiSuccess {String} type   类型  system：系统设置
     * @apiSuccess {String} value   值
     * @apiSuccess {String} created_at
     *
     * @apiUse            FailResponse
     */
    public function update(Request $request)
    {
        $setting = $this->settingService->handleUpdate($request);
        return $this->response->success(new SettingResource($setting));
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/11/6
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Illuminate\Validation\ValidationException
     *
     * @api               {put} settingAll 批量更新设置
     * @apiName           put_settingAll
     * @apiGroup          Setting
     *
     * @apiParam {Array} batch      二位数组
     * @apiParam {String} batch.id   ID
     * @apiParam {String} batch.type   类型  system：系统设置
     * @apiParam {String} batch.key   关键字
     * @apiParam {String} batch.title   中文名字
     * @apiParam {String} batch.value   值
     *
     * @apiUse            FailResponse
     */
    public function updateAll(Request $request)
    {
        $this->validate($request, [
            'batch' => 'required|array',
        ]);

        $this->settingService->handleUpdateAll($request->get('batch'));
        return $this->response->success();
    }

    public function updateUser(Request $request)
    {
        $setting = $this->settingService->handleUpdateUser($request);
        return $this->response->success(new SettingResource($setting));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }
}
