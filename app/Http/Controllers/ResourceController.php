<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2020/10/17
 * Time: 15:55
 */

namespace App\Http\Controllers;


use App\Exceptions\ApiHttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    const LOCAL_IMAGE_PATH = 'storage/uploads/images/';

    const ALLOW_FILE_TYPES = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

    /**
     * @author            : chunpat@163.com
     * Date: 2020/10/17
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource|void
     *
     * @throws ApiHttpException
     * @throws \Illuminate\Contracts\Filesystem\FileExistsException
     *
     * @api               {post} resource/image 上传图片
     * @apiName           post_uploadImage
     * @apiGroup          Resource
     *
     * @apiParam {File} image   文件  支持'gif','jpeg','png','bmp'
     * @apiParam {String} directory   目录
     *
     * @apiSuccess {String} url   全路径
     *
     * @apiSuccessExample Success-Response:
     * {"status":"success","code":200,"message":"\u64cd\u4f5c\u6210\u529f","data":{"url":"http:\/\/192.168.31.143:8090\/storage\/uploads\/images\/\u77e9\u5f62 1702@2x.png"}}
     * @apiUse            FailResponse
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file('image');
        $directory = $request->get('directory');
        $this->validate($request, [
            'image' => 'required|file',
        ]);
        //获取文件类型后缀
        $extension = $file->getClientOriginalExtension();
        //是否是要求的文件
        $isInFileType = in_array($extension, self::ALLOW_FILE_TYPES);
        if (!$isInFileType) {
            throw new ApiHttpException("文件格式不合法");
        }
//        $clientName = $filename->getClientOriginalName(); //客户端文件名称
        $stream = fopen($file->getRealPath(), 'r+');
        $storage = Storage::disk();
        $path = $directory ? $directory . '/' .$file->getClientOriginalName() : self::LOCAL_IMAGE_PATH . $file->getClientOriginalName();
        if (Storage::exists($path)) {
            throw new ApiHttpException('file name ' . $file->getClientOriginalName() . ' exist！！');
        }

        if (!$storage->writeStream($path, $stream)) {
            return $this->response->fail('error');
        }

        return $this->response->success([
            'url' => env('STATIC_HOST') . $path
        ]);
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/10/18
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function getImages(Request $request){
        $directory = $request->get('directory');
        $storage = Storage::disk();
        $directory = $directory ? $directory . '/' :self::LOCAL_IMAGE_PATH;
        $files = $storage->allFiles($directory);
        $result = [];
        foreach($files as $file){
            $result[] = env('STATIC_HOST')  . $file;
        }
        return $this->response->success($result);
    }

    public function file()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $storage = Storage::disk('local');
        $storage->setExtensions('csv,xls,xlsx');
        if (!$storage->root('uploads/fault')->put('file')) {
            return $this->failResponse($storage->getError());
        }
        return $this->successResponse(['url' => $storage->getUploadSuccessPath()]);
    }
}