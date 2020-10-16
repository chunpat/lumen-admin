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
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $this->middleware('refreshToken:api', ['except' => []]);
//        $this->middleware('auth:api', ['except' => ['store', 'show', 'index']]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
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
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"data":[{"id":1,"name":"chunpat","nickname":"","email":"398949389@qq.com","password":"$2y$10$0hwq6q8HLOuh1mevMNRpOuQJakELwR7h0g7ZD0GSZw2WgOfEOM1Ue","phone":null,"avatar":null,"introduction":null,"status":null},{"id":2,"name":"chunpat1","nickname":"","email":"3989493891@qq.com","password":"$2y$10$zBRIh\/MAF2oKGAws276cbeFAuUHHNSbtHS0pvdOfS2cVpNmAXZfDq","phone":null,"avatar":null,"introduction":null,"status":null},{"id":3,"name":"chunpat2","nickname":"","email":"3989493892@qq.com","password":"$2y$10$YdSrSGnMtOZd9GBCnOuWW.OF6tQYDde2OBD59wziL2zR1TQ8NKc82","phone":null,"avatar":null,"introduction":null,"status":null},{"id":4,"name":"chunpat3","nickname":"","email":"3989493893@qq.com","password":"$2y$10$pTqx7kOl2zsqlxifuWlJweAUH9K3M6IrS4rNDibFZ.uVpLCssU2lW","phone":null,"avatar":null,"introduction":null,"status":null},{"id":5,"name":"chunpat4","nickname":"","email":"3989493894@qq.com","password":"$2y$10$zexqZzKhaoE8QGsWVFjWPelpfPVuSGYHZaDD2.gaYRRSah6Bme1hy","phone":null,"avatar":null,"introduction":null,"status":null},{"id":6,"name":"chunpat1","nickname":"","email":"393893123@132.com","password":"$2y$10$NgnEoiGvYOUjHEYemR1UAOnhdBfZ5bzbPbfe97yTse2R.8OZBWNMi","phone":null,"avatar":null,"introduction":null,"status":null},{"id":7,"name":"chunpat","nickname":"","email":"chunpat@163.com","password":"$2y$10$X20DnIwulW0Ac65EqO2Ok.6gYobT.zAaRMk0N54x7GqIDebDA.LzS","phone":null,"avatar":null,"introduction":null,"status":null},{"id":8,"name":"chunpat","nickname":"","email":"3989493822@qq.com","password":"$2y$10$lfKSR9wy0CAUlHUvFVMceOGTTM03FWSks54arTKNjBKsnJqkupIUS","phone":null,"avatar":null,"introduction":null,"status":null},{"id":9,"name":"test","nickname":"test11","email":"test@163.com","password":"$2y$10$sClIbYjmTNw4LF1syWBZy.GS96k7A8hGuroAq7vffyrioilTimLJi","phone":"13456","avatar":"","introduction":"","status":0},{"id":10,"name":"test1","nickname":"test11","email":"tes1t@163.com","password":"$2y$10$domoY9j6lSwp\/0Yl8aLW.O1vRViw4iJm83rArWz3p.bV9gvPa30VO","phone":"134561","avatar":"","introduction":"","status":0}],"meta":{"pagination":{"total":10,"count":10,"per_page":10,"current_page":1,"total_pages":1,"links":{}}}}}
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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Illuminate\Validation\ValidationException
     *
     * @api               {post} users 新增用户
     * @apiName           post_users
     * @apiGroup          Users
     *
     * @apiParam {String} name 用户名 必填
     * @apiParam {String} nickname 昵称 必填
     * @apiParam {String} email 邮箱 必填
     * @apiParam {String} phone 电话 必填
     * @apiParam {String} password 密码 必填
     * @apiParam {String} gender 性别 1：男；2：女；3：未知
     * @apiParam {String} status 状态 0：禁用；1：启用；
     * @apiParam {String} avatar 头像
     * @apiParam {String} introduction 简介
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
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nickname' => 'required|string|max:100',
            'gender' => 'required|integer|between:1,3',
            'avatar' => 'string',
            'phone' => 'required|unique:users',
            'introduction' => 'string',
            'status' => 'integer|between:0,1',
        ]);

        $user = $this->userService->handleRegistration($request);

        return $this->response->created(new UserResource($user));
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/14
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Illuminate\Validation\ValidationException
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
        $this->validate($request, [
            'id' => 'required',
            'password' => 'required|min:8',
            'nickname' => 'required|string|max:100',
            'gender' => 'required|integer|between:1,3',
            'avatar' => 'string',
            'status' => 'integer|between:0,1',
            'introduction' => 'string',
        ]);

        $user = $this->userService->handleUpdate($request);
        return $this->response->success(new UserResource($user));
    }
}
