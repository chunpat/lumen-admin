<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserSettingResource;
use App\Services\UserSettingService;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    /**
    * @var UserSettingService
    */
    private $userSettingService;

    /**
     * UserSettingController constructor.
     *
     * @param UserSettingService   $userSettingService
     */
    public function __construct(UserSettingService $userSettingService)
    {
        $this->userSettingService = $userSettingService;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $userSettings = $this->userSettingService->handleList($request);
        return $this->response->success($userSettings);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     */
    public function store(Request $request)
    {
        $userSetting = $this->userSettingService->handleStore($request);
        return $this->response->created(new UserSettingResource($userSetting));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function show($id)
    {
        $userSetting = $this->userSettingService->handleProfile($id);
        return $this->response->success($userSetting);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @api               {put} userSetting 用户设置
     * @apiName           put_userSetting
     * @apiGroup          Users
     *
     * @apiUse          AuthorizationHeader
     *
     * @apiParam {Integer} id   ID
     * @apiParam {String} theme_color   theme_color
     * @apiParam {String} open_tags_view   open_tags_view
     * @apiParam {String} fixed_header   fixed_header
     * @apiParam {String} sidebar_logo   sidebar_logo
     *
     * @apiUse            FailResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);
        $userSetting = $this->userSettingService->handleUpdate($request);
        return $this->response->success(new UserSettingResource($userSetting));
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
