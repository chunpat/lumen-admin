<?php

namespace App\Services;

use App\Contracts\Repositories\LoginLogRepository;
use App\Repositories\Criteria\LoginLogCriteria;
use App\Repositories\Eloquent\LoginLogRepositoryEloquent;
use App\Repositories\Enums\StatusEnum;
use App\Repositories\Presenters\LoginLogPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\IpUtils;

class LoginLogService
{
    /**
     * @var LoginLogRepositoryEloquent
     */
    private $loginLogRepository;

    /**
     * LoginLogService constructor.
     *
     * @param LoginLogRepositoryEloquent $loginLogRepositoryEloquent
     */
    public function __construct(LoginLogRepositoryEloquent $loginLogRepositoryEloquent)
    {
        $this->loginLogRepository = $loginLogRepositoryEloquent;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function handleList(Request $request)
    {
        $this->loginLogRepository->pushCriteria(new LoginLogCriteria($request));
        $this->loginLogRepository->setPresenter(LoginLogPresenter::class);

        return $this->loginLogRepository->searchLoginLogsByPage();
    }

    /**
     * @author: chunpat@163.com
     * Date: 2020/11/4
     *
     * @param Request $request
     * @param string  $errMessage
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handleStore(Request $request, string $errMessage = '')
    {
        $agent = new Agent();

        $browser = $agent->browser();
        $browserVersion = $agent->version($browser);
        $platform = $agent->platform();
        $platformVersion = $agent->version($platform);

        return $this->loginLogRepository->create([
            'name' => $request->get('name'),
            'ip' => $request->getClientIp(),
            'browser' => $browser . ' ' . $browserVersion,
            'platform' => $platform . ' ' . $platformVersion,
            'location' => '-',
            'status' => empty($errMessage) ? StatusEnum::AVAILABLE : StatusEnum::DISABLED,
            'desc' => $errMessage
        ]);
    }
}
