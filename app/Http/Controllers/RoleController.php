<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;

        $this->middleware('refreshToken:api', ['except' => []]);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @api               {get} role 角色列表
     * @apiName           get_role
     * @apiGroup          Role
     *
     * @apiParam {String} name 角色名称
     * @apiParam {String} en 权限字符
     *
     * @apiSuccess {String} id   ID
     * @apiSuccess {String} name   角色名称
     * @apiSuccess {String} en   权限字符
     * @apiSuccess {String} remark   备注
     * @apiSuccess {String} sort   排序
     * @apiSuccess {String} status   状态
     * @apiSuccess {Array} menu_ids   权限id 如：[2, 3, 43, 44, 45, 46, 5]
     * @apiSuccess {String} created_at
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"current_page":1,"data":[{"id":1,"name":"\u7ba1\u7406\u5458","en":"admin","created_at":"2020-10-14 08:43:54","updated_at":"2020-10-14 08:43:54","status":0,"sort":0,"remark":null,"menu_ids":[1,2,3,37]},{"id":2,"name":"\u7ba1\u7406\u5458","en":"guest","created_at":"2020-10-14 08:44:24","updated_at":"2020-10-14 08:49:00","status":0,"sort":0,"remark":null,"menu_ids":[1]},{"id":3,"name":"\u7ba1\u7406\u5458","en":"guest1","created_at":"2020-10-14 08:53:57","updated_at":"2020-10-14 08:53:57","status":0,"sort":0,"remark":null,"menu_ids":[]}],"first_page_url":"http:\/\/127.0.0.1:8080\/api\/v1\/role?page=1","from":1,"last_page":1,"last_page_url":"http:\/\/127.0.0.1:8080\/api\/v1\/role?page=1","next_page_url":null,"path":"http:\/\/127.0.0.1:8080\/api\/v1\/role","per_page":10,"prev_page_url":null,"to":3,"total":3}}
     * @apiUse            FailResponse
     */
    public function index(Request $request)
    {
        $roles = $this->roleService->handleList($request);

        return $this->response->success($roles);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     *
     * @api               {post} role 保存角色
     * @apiName           post_role
     * @apiGroup          Role
     *
     * @apiParam {String} name   角色名称
     * @apiParam {String} en   权限字符
     * @apiParam {String} remark   备注
     * @apiParam {String} sort   排序
     * @apiParam {String} status   状态
     * @apiParam {Array} menu_ids   权限id 如：[2, 3, 43, 44, 45, 46, 5]
     *
     * @apiSuccess {String} id   ID
     * @apiSuccess {String} name   角色名称
     * @apiSuccess {String} en   权限字符
     * @apiSuccess {String} remark   备注
     * @apiSuccess {String} sort   排序
     * @apiSuccess {String} status   状态
     * @apiSuccess {String} created_at
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":201,"message":"Created","data":{"id":3,"name":"\u7ba1\u7406\u5458","en":"guest1","created_at":"2020-10-14 08:53:57"}}
     * @apiUse            FailResponse
     */
    public function store(Request $request)
    {
        $this->validateData($request);

        $user = $this->roleService->handleRegistration($request);

        return $this->response->created(new RoleResource($user));
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @api               {put} role 更新角色
     * @apiName           put_role
     * @apiGroup          Role
     *
     * @apiParam {String} id   ID
     * @apiParam {String} name   角色名称
     * @apiParam {String} en   权限字符
     * @apiParam {String} remark   备注
     * @apiParam {String} sort   排序
     * @apiParam {String} status   状态
     *
     * @apiSuccess {String} id   ID
     * @apiSuccess {String} name   角色名称
     * @apiSuccess {String} en   权限字符
     * @apiSuccess {String} remark   备注
     * @apiSuccess {String} sort   排序
     * @apiSuccess {String} status   状态
     * @apiSuccess {String} created_at
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"id":2,"name":"\u7ba1\u7406\u5458","en":"guest","created_at":"2020-10-14 08:44:24"}}
     * @apiUse            FailResponse
     */
    public function update(Request $request)
    {
        $this->validateData($request);
        $user = $this->roleService->handleUpdate($request);
        return $this->response->success(new RoleResource($user));
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     * @param $request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateData($request){
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required|max:20',
            'en' => 'required|max:20',
            'remark' => 'required|max:255',
            'sort' => 'required|integer|max:127',
            'status' => 'required|integer|between:0,1'
        ]);
    }
}
