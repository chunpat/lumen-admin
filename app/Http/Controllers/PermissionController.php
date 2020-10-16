<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2020/10/15
 * Time: 09:53
 */

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionController
 * @package App\Http\Controllers
 */
class PermissionController extends Controller
{
    /**
     * @var PermissionService
     */
    private $permissionService;


    private $userService;

    /**
     * PermissionController constructor.
     *
     * @param PermissionService $permissionService
     * @param UserService $userService
     */
    public function __construct(PermissionService $permissionService,UserService $userService)
    {
        $this->permissionService = $permissionService;
        $this->userService = $userService;
        $this->middleware('refreshToken:api', ['except' => []]);
    }

    /**
     * @author            : chunpat@163.com
     * Date: 2020/10/15
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     *
     * @api               {get} menus 权限列表
     * @apiName           get_menus
     * @apiGroup          Permission
     *
     * @apiSuccess {String} id   ID
     * @apiSuccess {String} type   类型  view:页面;api:接口
     * @apiSuccess {String} name   路由名称
     * @apiSuccess {String} title   菜单标题
     * @apiSuccess {String} icon   菜单图标
     * @apiSuccess {String} path   路由地址
     * @apiSuccess {String} paths   全路径冗余字段
     * @apiSuccess {String} component   组件路径
     * @apiSuccess {Integer} is_redirect   this route cannot be clicked in breadcrumb navigation when noRedirect is set，如果1：redirect = path
     * @apiSuccess {Integer} is_always_show   will always show the root menu
     * @apiSuccess {Integer} is_hidden   是否隐藏
     * @apiSuccess {Integer} is_no_cache   是否不缓存
     * @apiSuccess {Integer} is_affix   affix
     * @apiSuccess {String} parent_id   菜单图标
     * @apiSuccess {Integer} sort   排序
     * @apiSuccess {Array} children   子层级
     * @apiSuccess {String} created_at
     *
     * @apiSuccessExample Success-Response:
     *  {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"current_page":1,"data":[{"id":1,"name":"Permission","title":"\u6743\u9650\u7ba1\u7406","icon":"lock","path":"\/permission","paths":null,"component":"Layout","is_redirect":1,"is_always_show":1,"is_hidden":0,"is_no_cache":1,"parent_id":0,"created_at":"2020-10-15 11:19:45","updated_at":null,"deleted_at":null,"is_affix":0,"type":"view","children":[{"id":2,"name":"PagePermission","title":"\u6743\u9650\u9875\u9762","icon":null,"path":"page","paths":null,"component":"permission\/page","is_redirect":1,"is_always_show":1,"is_hidden":0,"is_no_cache":1,"parent_id":1,"created_at":null,"updated_at":null,"deleted_at":null,"is_affix":0,"type":"view","children":[]},{"id":3,"name":"Sub","title":"\u6743\u9650\u5b50\u9875\u9762","icon":null,"path":null,"paths":null,"component":null,"is_redirect":1,"is_always_show":1,"is_hidden":0,"is_no_cache":1,"parent_id":1,"created_at":null,"updated_at":null,"deleted_at":null,"is_affix":0,"type":"view","children":[]}]}],"first_page_url":"http:\/\/127.0.0.1:8080\/api\/v1\/permissionMenu?page=1","from":1,"last_page":1,"last_page_url":"http:\/\/127.0.0.1:8080\/api\/v1\/permissionMenu?page=1","next_page_url":null,"path":"http:\/\/127.0.0.1:8080\/api\/v1\/permissionMenu","per_page":10,"prev_page_url":null,"to":1,"total":1}}
     *
     * @apiUse            FailResponse
     *
     */
    public function permissionMenus(Request $request)
    {
        $user = $this->userService->getDetailByAuth();
        $permissionIds = [];
        foreach ($user->roles as $role){
            foreach ($role->permissions as $permission){
                $permissionIds[] = $permission->id;
            }
        }
        $permissionIds = array_unique($permissionIds);
        $permission = $this->permissionService->menus($permissionIds);

        return $this->response->success($permission);
    }

    /**
     * @author            : chunpat@163.com
     * Date: 2020/10/15
     *
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     *
     * @api               {get} permissionMenus 当前用户权限列表
     * @apiName           get_permissionMenus
     * @apiGroup          Permission
     *
     * @apiSuccess {String} id   ID
     * @apiSuccess {String} type   类型  view:页面;api:接口
     * @apiSuccess {String} name   路由名称
     * @apiSuccess {String} title   菜单标题
     * @apiSuccess {String} icon   菜单图标
     * @apiSuccess {String} path   路由地址
     * @apiSuccess {String} paths   全路径冗余字段
     * @apiSuccess {String} component   组件路径
     * @apiSuccess {Integer} is_redirect   this route cannot be clicked in breadcrumb navigation when noRedirect is set，如果1：redirect = path
     * @apiSuccess {Integer} is_always_show   will always show the root menu
     * @apiSuccess {Integer} is_hidden   是否隐藏
     * @apiSuccess {Integer} is_no_cache   是否不缓存
     * @apiSuccess {Integer} is_affix   affix
     * @apiSuccess {String} parent_id   菜单图标
     * @apiSuccess {Integer} sort   排序
     * @apiSuccess {Array} children   子层级
     * @apiSuccess {String} created_at
     *
     * @apiSuccessExample Success-Response:
     *  {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":[{"id":1,"name":"Permission","title":"\u6743\u9650\u7ba1\u7406","icon":"lock","path":"\/permission","paths":null,"component":"Layout","is_redirect":1,"is_always_show":1,"is_hidden":0,"is_no_cache":1,"parent_id":0,"created_at":"2020-10-15 11:19:45","updated_at":null,"deleted_at":null,"is_affix":0,"type":"view","sort":0,"children":[{"id":2,"name":"PagePermission","title":"\u6743\u9650\u9875\u9762","icon":null,"path":"page","paths":null,"component":"permission\/page","is_redirect":1,"is_always_show":1,"is_hidden":0,"is_no_cache":1,"parent_id":1,"created_at":null,"updated_at":null,"deleted_at":null,"is_affix":0,"type":"view","sort":0,"children":[{"id":3,"name":"Sub","title":"\u6743\u9650\u5b50\u9875\u9762","icon":null,"path":null,"paths":null,"component":null,"is_redirect":1,"is_always_show":1,"is_hidden":0,"is_no_cache":1,"parent_id":2,"created_at":null,"updated_at":null,"deleted_at":null,"is_affix":0,"type":"view","sort":0,"children":[]}]}]},{"id":37,"name":"222","title":"\u6d4b\u8bd5","icon":null,"path":null,"paths":null,"component":null,"is_redirect":1,"is_always_show":1,"is_hidden":0,"is_no_cache":1,"parent_id":0,"created_at":null,"updated_at":null,"deleted_at":null,"is_affix":0,"type":null,"sort":0,"children":[]}]}
     *
     * @apiUse            FailResponse
     *
     */
    public function menus(Request $request)
    {
        $permission = $this->permissionService->handleList($request);

        return $this->response->success($permission);


    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     * @throws \Illuminate\Validation\ValidationException
     *
     * @api               {post} permissionMenu 添加权限
     * @apiName           post_permissionMenu
     * @apiGroup          Permission
     *
     * @apiParam {String} type   类型  view:页面;api:接口
     * @apiParam {String} name   路由名称
     * @apiParam {String} title   菜单标题
     * @apiParam {String} icon   菜单图标
     * @apiParam {String} path   路由地址
     * @apiParam {String} component   组件路径
     * @apiParam {Integer} is_redirect   this route cannot be clicked in breadcrumb navigation when noRedirect is set，如果1：redirect = path
     * @apiParam {Integer} is_always_show   will always show the root menu
     * @apiParam {Integer} is_hidden   是否隐藏
     * @apiParam {Integer} is_no_cache   是否不缓存
     * @apiParam {Integer} is_affix   affix
     * @apiParam {String} parent_id   菜单图标
     * @apiParam {Integer} sort   排序
     *
     * @apiSuccessExample Success-Response:
     *  {"status":"success","code":201,"message":"Created","data":{"id":33,"name":"name","title":"title","type":"view","icon":"test","path":"dsadsadsa","paths":"\/1\/33","component":"Layout","is_redirect":1,"is_affix":0,"is_always_show":1,"is_hidden":0,"is_no_cache":1,"parent_id":1,"sort":0,"created_at":"2020-10-15 08:12:07"}}
     *
     * @apiUse            FailResponse
     */
    public function store(Request $request)
    {
        $this->validateData($request);

        $permission = DB::transaction(function () use ($request) {
            $permissionResource = $this->permissionService->handleCreate($request);
            return $this->permissionService->updatePaths($permissionResource->id);
        });

        return $this->response->created(new PermissionResource($permission));
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
     * @api               {put} permissionMenu 编辑权限
     * @apiName           put_permissionMenu
     * @apiGroup          Permission
     *
     * @apiParam {Integer} id
     * @apiParam {String} type   类型  view:页面;api:接口
     * @apiParam {String} name   路由名称
     * @apiParam {String} title   菜单标题
     * @apiParam {String} icon   菜单图标
     * @apiParam {String} path   路由地址
     * @apiParam {String} component   组件路径
     * @apiParam {Integer} is_redirect   this route cannot be clicked in breadcrumb navigation when noRedirect is set，如果1：redirect = path
     * @apiParam {Integer} is_always_show   will always show the root menu
     * @apiParam {Integer} is_hidden   是否隐藏
     * @apiParam {Integer} is_no_cache   是否不缓存
     * @apiParam {Integer} is_affix   affix
     * @apiParam {String} parent_id   菜单图标
     * @apiParam {Integer} sort   排序
     *
     * @apiSuccessExample Success-Response:
     *  {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"id":32,"name":"name32","title":"title","type":"view","icon":"test","path":"dsadsadsa","paths":"\/1\/32","component":"Layout","is_redirect":1,"is_affix":0,"is_always_show":1,"is_hidden":0,"is_no_cache":1,"parent_id":1,"sort":0,"created_at":"2020-10-15 08:10:41"}}
     *
     */
    public function update(Request $request)
    {
        $this->validateData($request);

        $permission = $this->permissionService->handleUpdate($request);
        return $this->response->success(new PermissionResource($permission));
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/15
     *
     * @param $request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateData($request){
        $this->validate($request, [
            'id' => 'required|integer',
            'name' => 'required|string|max:30',
            'title' => 'required|string|max:30',
            'type' => 'required|string|max:10',
            'icon' => 'required|string|max:30',
            'path' => 'required|string|max:100',
            'component' => 'required|string|max:30',
            'is_redirect' => 'integer|between:0,1',
            'is_affix' => 'integer|between:0,1',
            'is_always_show' => 'integer|between:0,1',
            'is_hidden' => 'integer|between:0,1',
            'is_no_cache' => 'integer|between:0,1',
            'parent_id' => 'integer',
            'sort' => 'integer',
        ]);
    }
}