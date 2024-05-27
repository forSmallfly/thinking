<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use app\FactoryServer;
use think\annotation\route\Route;
use think\Response;

class Common extends BaseController
{
    /**
     * 注册
     *
     * @return Response
     */
    #[Route("POST", "common/register")]
    public function register(): Response
    {
        $params = $this->request->getParams();

        // 检测用户是否存在
        $isExists = FactoryServer::getRegisterServer()->isExistsUser($params);
        if ($isExists) {
            return $this->fail(-1, '用户名已存在');
        }

        // 创建用户
        $uid = FactoryServer::getRegisterServer()->createUser($params);
        return $uid ? $this->success() : $this->fail();
    }

    /**
     * 登录
     *
     * @return Response
     */
    #[Route("POST", "common/login")]
    public function login(): Response
    {
        $params = $this->request->getParams();

        // 获取用户信息
        $userInfo = FactoryServer::getLoginServer()->getUserInfo($params);
        if (empty($userInfo)) {
            return $this->fail(-1, '用户名或密码错误');
        }

        // 验证密码
        $result = FactoryServer::getLoginServer()->passwordVerify($params['password'], $userInfo['password']);
        if (!$result) {
            return $this->fail(-1, '用户名或密码错误');
        }

        // 加密数据
        $token = $this->encryptRSA((string)$userInfo['id']);
        return $this->success([
            'token' => $token
        ]);
    }

    /**
     * 退出
     *
     * @return Response
     */
    #[Route("POST", "common/logout")]
    public function logout(): Response
    {
        return $this->success();
    }
}