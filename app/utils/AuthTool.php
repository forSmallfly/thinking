<?php

namespace app\utils;

use app\exceptions\UnauthorizedException;
use app\exceptions\UnauthorizedOperationException;
use app\FactoryModel;
use Throwable;

trait AuthTool
{
    use RsaTool;

    /**
     * 校验token
     *
     * @return int
     */
    private function checkToken(): int
    {
        // 判断是否在免登录名单中
        if (!$this->isInExemptLoginList()) {
            $token = $this->getToken();
            if (empty($token)) {
                throw new UnauthorizedException();
            }

            // 解析token
            $uid = $this->parseToken($token);

            // 权限检测
            if ($uid != 1) {
                $this->checkAuth($uid);
            }

            return $uid;
        }

        return 0;
    }

    /**
     * 权限检测
     *
     * @param int $uid
     * @return void
     */
    private function checkAuth(int $uid): void
    {
        // 判断是否在接口白名单中
        if (!$this->isInApiWhiteList()) {
            // 获取用户拥有的角色ID列表
            $roleIdList = FactoryModel::getModel('user')->getRoleIdList($uid);
            if (empty($roleIdList)) {
                throw new UnauthorizedOperationException();
            }

            // 获取角色拥有的权限ID列表
            $ruleIdList = FactoryModel::getModel('role')->getRuleIdList($roleIdList);
            if (empty($ruleIdList)) {
                throw new UnauthorizedOperationException();
            }

            // 根据URL获取权限ID
            $url    = $this->getCurrentUrl();
            $ruleId = FactoryModel::getModel('rule')->getRuleIdFromUrl($url);
            if (!in_array($ruleId, $ruleIdList)) {
                throw new UnauthorizedOperationException();
            }
        }
    }

    /**
     * 判断是否在免登录名单中
     *
     * @return bool
     */
    private function isInExemptLoginList(): bool
    {
        $rule = $this->getCurrentUrl();

        return in_array($rule, config('api.exempt_login'));
    }

    /**
     * 判断是否在接口白名单中
     *
     * @return bool
     */
    private function isInApiWhiteList(): bool
    {
        $rule = $this->getCurrentUrl();

        return in_array($rule, config('api.white_list'));
    }

    /**
     * 获取当前请求URL
     *
     * @return string
     */
    private function getCurrentUrl(): string
    {
        return request()->controller() . '/' . request()->action();
    }

    /**
     * 获取token
     *
     * @return string
     */
    private function getToken(): string
    {
        return request()->header('token', '');
    }

    /**
     * 解析token
     *
     * @param string $token
     * @return int
     */
    private function parseToken(string $token): int
    {
        try {
            $uid = (int)$this->decryptRSA($token);
            if (empty($uid)) {
                throw new UnauthorizedException();
            }

            return $uid;
        } catch (Throwable) {
            throw new UnauthorizedException();
        }
    }
}