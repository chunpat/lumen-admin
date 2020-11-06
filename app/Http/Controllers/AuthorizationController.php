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
use App\Repositories\Enums\ResponseCodeEnum;
use App\Repositories\Models\User;
use App\Repositories\Models\UserSetting;
use App\Services\LoginLogService;
use App\Services\UserSettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{
    /**
     * @var LoginLogService
     */
    private $loginLogService;

    /**
     * @var UserSettingService
     */
    private $userSettingService;

    /**
     * Create a new AuthController instance.
     * @param LoginLogService   $loginLogService
     * @param UserSettingService   $userSettingService
     */
    public function __construct(LoginLogService $loginLogService,UserSettingService $userSettingService)
    {
        $this->middleware('refreshToken:api', ['except' => ['store']]);
        $this->loginLogService = $loginLogService;
        $this->userSettingService = $userSettingService;
//        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     *
     * @api               {delete} authorization 注销
     * @apiName           delete_authorization
     * @apiGroup          Authorization
     *
     * @apiUse AuthorizationHeader
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 204 OK
     * @apiUse            FailResponse
     */
    public function destroy()
    {
        auth()->logout();

        return $this->response->noContent();
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/11/6
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @api               {get} authorization 查看用户信息
     * @apiName           get_authorization
     * @apiGroup          Authorization
     *
     * @apiUse AuthorizationHeader
     *
     * @apiSuccess {String} nickname   昵称
     * @apiSuccess {String} email   邮箱
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"id":7,"name":"chunpat","nickname":"chunpat","phone":"13726271207","email":"chunpat@163.com","avatar":"https:\/\/wpimg.wallstcn.com\/f778738c-e4f8-4870-b634-56703b4acafe.gif","introduction":"11111","status":1,"gender":1,"user_setting":{"user_id":7,"theme_color":"#1890FF","open_tags_view":1,"fixed_header":0,"sidebar_logo":0,"updated_at":"2020-11-06T09:54:53.000000Z","created_at":"2020-11-06T09:54:53.000000Z","id":5},"created_at":"2020-09-24 08:46:43"}}
     * @apiUse            FailResponse
     */
    public function show(Request $request)
    {
        $user = auth()->userOrFail();
        $userSetting = (new UserSetting())->where('user_id',$user->id)->first();
        if(empty($userSetting)){
            $userSetting = $this->userSettingService->handleStore([
                'user_id'=>Auth::id(),
                'theme_color'=>'#1890FF',
                'open_tags_view'=>1,
                'fixed_header'=>0,
                'sidebar_logo'=>0,
            ]);
        }
        $user->setRelation('user_setting',$userSetting);
        return $this->response->success(new UserResource($user));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Illuminate\Validation\ValidationException
     *
     * @api               {post} authorization 登录
     * @apiName           post_authorization
     * @apiGroup          Authorization
     *
     * @apiParam {String} email email和name二选一
     * @apiParam {String} name email和name二选一
     * @apiParam {String} password password
     *
     * @apiSuccess {String} access_token   token
     * @apiSuccess {String} token_type   token类型
     * @apiSuccess {String} expires_in   过期时效
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *       "email": 3989493894@qq.com,
     *       "password": 12345678
     *     }
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200102,"message":"\u767b\u5f55\u6210\u529f","data":{"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODg4OFwvYXV0aG9yaXphdGlvbiIsImlhdCI6MTYwMDkzMDcyNCwiZXhwIjoxNjAwOTM0MzI0LCJuYmYiOjE2MDA5MzA3MjQsImp0aSI6ImFTdHFYbmRCaTBqNmQ0Y1kiLCJzdWIiOjUsInBydiI6IjcxMTA3ZWU2YWM4ZWRlYmEwYzgxZDUwNTJlNzI3NjU1ZDE3YzZiMTEifQ.SJewEiK41ki7_yoa7KdS8F2YUCU-qt_iKOC7bK6JTDk","token_type":"bearer","expires_in":3600}}
     * @apiUse            FailResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'filled|email',
            'name' => 'required_without:email',
            'password' => 'required',
        ]);

        $credentials = request(['name', 'email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            //失败记录
            $this->loginLogService->handleStore($request,false);
            $this->response->errorUnauthorized();
        }
        //成功记录
        $this->loginLogService->handleStore($request,true);

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     *
     * @api               {put} authorization 更新令牌
     * @apiName           put_authorization
     * @apiGroup          Authorization
     *
     * @apiUse          AuthorizationHeader
     *
     * @apiSuccess {String} access_token   token
     * @apiSuccess {String} token_type   token类型
     * @apiSuccess {String} expires_in   过期时效
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200102,"message":"\u767b\u5f55\u6210\u529f","data":{"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODg4OFwvYXV0aG9yaXphdGlvbiIsImlhdCI6MTYwMDkzNDQzMiwiZXhwIjoxNjAwOTM4MTEwLCJuYmYiOjE2MDA5MzQ1MTAsImp0aSI6IkpiZW56V2lVN25VT0tPbWciLCJzdWIiOjUsInBydiI6IjcxMTA3ZWU2YWM4ZWRlYmEwYzgxZDUwNTJlNzI3NjU1ZDE3YzZiMTEifQ.S69iMDwoCg23Ipu3Zwnm_EE7Z6MIgVN5MpZOzjSfO1s","token_type":"bearer","expires_in":3600}}
     * @apiUse            FailResponse
     */
    public function update()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return $this->response->success(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ],
            '',
            ResponseCodeEnum::SERVICE_LOGIN_SUCCESS
        );
    }
}
