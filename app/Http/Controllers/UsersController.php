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

use App\Http\Resources\UserResource;
use App\Repositories\Validators\UserValidator;
use App\Services\UserService;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserValidator
     */
    private $userValidator;

    public function __construct(UserService $userService,UserValidator $userValidator)
    {
        $this->userService = $userService;

        $this->userValidator = $userValidator;

        $this->middleware('refreshToken:api', ['except' => []]);
//        $this->middleware('auth:api', ['except' => ['store', 'show', 'index']]);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/17
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @api               {get} users 获取用户列表
     * @apiName           get_users
     * @apiGroup          Users
     *
     * @apiParam {String} name 用户名
     * @apiParam {String} nickname 昵称
     * @apiParam {String} email  邮箱
     * @apiParam {String} phone  电话
     * @apiParam {String} status  状态
     *
     * @apiSuccess {Array} data  列表数据.
     * @apiSuccess {String} data.nickname   昵称
     * @apiSuccess {String} data.email   邮箱
     * @apiSuccess {String} data.phone   电话
     * @apiSuccess {String} data.status   状态
     * @apiSuccess {String} data.avatar   头像
     * @apiSuccess {String} data.gender   性别
     * @apiSuccess {Array} data.user_roles   状态
     * @apiSuccess {String} data.user_roles.role_id   角色id
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"current_page":1,"data":[{"id":1,"name":"\u6d4b\u8bd5\u9e4f","email":"2121321321","created_at":"2020-10-17T02:33:16.000000Z","updated_at":"2020-10-17T02:33:16.000000Z","nickname":"zzhpeng","introduction":"","avatar":"","status":0,"gender":3,"deleted_at":null,"phone":"13726271207","user_roles":[]},{"id":7,"name":"chunpat","email":"chunpat@163.com","created_at":"2020-09-24T08:46:43.000000Z","updated_at":"2020-09-24T08:46:43.000000Z","nickname":"","introduction":null,"avatar":null,"status":null,"gender":null,"deleted_at":null,"phone":null,"user_roles":[{"id":1,"role_id":1,"user_id":7},{"id":2,"role_id":2,"user_id":7}]},{"id":8,"name":"\u6d4b\u8bd5\u9e4f","email":"2121321321333","created_at":"2020-10-17T02:36:38.000000Z","updated_at":"2020-10-17T02:36:38.000000Z","nickname":"zzhpeng","introduction":"","avatar":"","status":0,"gender":3,"deleted_at":null,"phone":"13726271207","user_roles":[{"id":3,"role_id":1,"user_id":8},{"id":4,"role_id":2,"user_id":8}]},{"id":10,"name":"\u6d4b\u8bd5\u9e4f","email":"321321@137","created_at":"2020-10-17T02:40:26.000000Z","updated_at":"2020-10-17T02:40:26.000000Z","nickname":"zzhpeng","introduction":"","avatar":"","status":0,"gender":3,"deleted_at":null,"phone":"13726271208","user_roles":[{"id":5,"role_id":1,"user_id":10},{"id":6,"role_id":2,"user_id":10}]}],"first_page_url":"http:\/\/127.0.0.1:8080\/api\/v1\/users?page=1","from":1,"last_page":1,"last_page_url":"http:\/\/127.0.0.1:8080\/api\/v1\/users?page=1","next_page_url":null,"path":"http:\/\/127.0.0.1:8080\/api\/v1\/users","per_page":10,"prev_page_url":null,"to":4,"total":4}}
     *
     * @apiUse            FailResponse
     */
    public function index(Request $request)
    {
        $users = $this->userService->handleList($request);

        return $this->response->success($users);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     *
     * @api               {get} users/:id 获取用户
     * @apiName           get_users_by_id
     * @apiGroup          Users
     *
     * @apiParam {Number} id Users unique ID.
     *
     * @apiSuccess {String} nickname   昵称
     * @apiSuccess {String} email   邮箱
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"id":1,"name":"chunpat","nickname":"","email":"398949389@qq.com","password":"$2y$10$0hwq6q8HLOuh1mevMNRpOuQJakELwR7h0g7ZD0GSZw2WgOfEOM1Ue","phone":null,"avatar":null,"introduction":null,"status":null}}
     * @apiUse            FailResponse
     */
    public function show($id)
    {
        $user = $this->userService->handleProfile($id);

        return $this->response->success($user);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/17
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \Throwable
     *
     * @api               {post} users 新增用户
     * @apiName           post_users
     * @apiGroup          Users
     *
     * @apiParam {String} name 用户名称 必填
     * @apiParam {String} nickname 昵称 必填
     * @apiParam {String} email 邮箱 必填
     * @apiParam {String} phone 电话 必填
     * @apiParam {String} password 密码 必填
     * @apiParam {String} gender 性别 1：男；2：女；3：未知
     * @apiParam {String} status 状态 0：禁用；1：启用；
     * @apiParam {String} avatar 头像
     * @apiParam {String} introduction 简介
     * @apiParam {Array} role_ids 用户角色 如:[1,2,3]
     *
     * @apiSuccess {String} nickname   昵称
     * @apiSuccess {String} email   邮箱
     * @apiSuccess {String} ....   和请求一致
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":201,"message":"Created","data":{"name":"test1","nickname":"test11","phone":"134561","email":"tes1t@163.com","avatar":"https:\/\/wpimg.wallstcn.com\/f778738c-e4f8-4870-b634-56703b4acafe.gif","introduction":"","status":0,"roles":["admin"]}}
     * @apiUse            FailResponse
     */
    public function store(Request $request)
    {
        $this->userValidator->with( $request->all() )->passesOrFail(ValidatorInterface::RULE_CREATE);
        $user = $this->userService->handleRegistration($request);
        return $this->response->created(new UserResource($user));
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @api               {put} users 更新用户
     * @apiName           put_users
     * @apiGroup          Users
     *
     * @apiParam {String} id 用户id 必填
     * @apiParam {String} nickname 昵称 必填
     * @apiParam {String} password 密码 必填
     * @apiParam {String} gender 性别 1：男；2：女；3：未知
     * @apiParam {String} status 状态 0：禁用；1：启用；
     * @apiParam {String} avatar 头像
     * @apiParam {String} introduction 简介
     * @apiParam {Array} role_ids 用户角色 如:[1,2,3]
     *
     * @apiSuccess {String} nickname   昵称
     * @apiSuccess {String} email   邮箱
     * @apiSuccess {String} ....   和请求一致
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"name":"chunpat1","nickname":"1231","phone":null,"email":"3989493891@qq.com","avatar":"https:\/\/wpimg.wallstcn.com\/f778738c-e4f8-4870-b634-56703b4acafe.gif","introduction":"","status":0,"gender":"1","roles":["admin"]}}
     * @apiUse            FailResponse
     */
    public function update(Request $request)
    {
        $this->userValidator->with( $request->all() )->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $user = $this->userService->handleUpdate($request);
        return $this->response->success(new UserResource($user));
    }
}
