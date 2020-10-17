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
use App\Repositories\Validators\RoleValidator;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;

class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    private $roleService;

    /**
     * @var RoleValidator
     */
    private $roleValidator;

    public function __construct(RoleService $roleService,RoleValidator $roleValidator)
    {
        $this->roleService = $roleService;
        $this->roleValidator = $roleValidator;

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
     * @api               {get} roles 角色列表
     * @apiName           get_roles
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
     * @apiSuccess {Array}  role_permissions   权限
     * @apiSuccess {String}  role_permissions.permission_id   权限id
     * @apiSuccess {String} created_at
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"current_page":1,"data":[{"id":1,"name":"\u7ba1\u7406\u5458","en":"admin","created_at":"2020-10-14T08:43:54.000000Z","updated_at":"2020-10-14T08:43:54.000000Z","deleted_at":null,"status":0,"sort":0,"remark":null,"role_permissions":[{"id":1,"permission_id":1},{"id":2,"permission_id":2},{"id":4,"permission_id":3},{"id":5,"permission_id":37}]},{"id":2,"name":"\u7ba1\u7406\u5458","en":"guest","created_at":"2020-10-14T08:44:24.000000Z","updated_at":"2020-10-14T08:49:00.000000Z","deleted_at":null,"status":0,"sort":0,"remark":null,"role_permissions":[{"id":3,"permission_id":1}]},{"id":3,"name":"\u7ba1\u7406\u5458","en":"guest1","created_at":"2020-10-14T08:53:57.000000Z","updated_at":"2020-10-14T08:53:57.000000Z","deleted_at":null,"status":0,"sort":0,"remark":null,"role_permissions":[]},{"id":4,"name":"\u8d22\u52a1","en":"financial","created_at":"2020-10-16T16:35:54.000000Z","updated_at":"2020-10-16T16:35:54.000000Z","deleted_at":null,"status":0,"sort":0,"remark":null,"role_permissions":[]},{"id":11,"name":"\u8d22\u52a1","en":"financial4","created_at":"2020-10-16T16:39:44.000000Z","updated_at":"2020-10-16T17:34:56.000000Z","deleted_at":null,"status":1,"sort":1,"remark":"financial","role_permissions":[{"id":43,"permission_id":1},{"id":44,"permission_id":2},{"id":45,"permission_id":3},{"id":46,"permission_id":4}]},{"id":13,"name":"\u8d22\u52a1","en":"financial2","created_at":"2020-10-16T16:40:37.000000Z","updated_at":"2020-10-16T16:40:37.000000Z","deleted_at":null,"status":0,"sort":0,"remark":null,"role_permissions":[{"id":9,"permission_id":1},{"id":10,"permission_id":2},{"id":11,"permission_id":3}]},{"id":14,"name":"\u8d22\u52a1","en":"financial3","created_at":"2020-10-16T16:45:01.000000Z","updated_at":"2020-10-16T16:45:01.000000Z","deleted_at":null,"status":1,"sort":1,"remark":"financial","role_permissions":[{"id":12,"permission_id":1},{"id":13,"permission_id":2},{"id":14,"permission_id":3}]}],"first_page_url":"http:\/\/127.0.0.1:8080\/api\/v1\/roles?page=1","from":1,"last_page":1,"last_page_url":"http:\/\/127.0.0.1:8080\/api\/v1\/roles?page=1","next_page_url":null,"path":"http:\/\/127.0.0.1:8080\/api\/v1\/roles","per_page":10,"prev_page_url":null,"to":7,"total":7}}
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
        $this->roleValidator->with( $request->all() )->passesOrFail(ValidatorInterface::RULE_CREATE);
        $user = $this->roleService->handleRegistration($request);
        return $this->response->created(new RoleResource($user));
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
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
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"id":2,"name":"\u7ba1\u7406\u5458","en":"guest","created_at":"2020-10-14 08:44:24"}}
     * @apiUse            FailResponse
     */
    public function update(Request $request)
    {
        $this->roleValidator->with( $request->all() )->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $role = $this->roleService->handleUpdate($request);
        return $this->response->success(new RoleResource($role));
    }
}
