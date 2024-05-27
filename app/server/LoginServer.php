<?php

namespace app\server;

use app\BaseModel;
use app\FactoryModel;

class LoginServer
{
    /**
     * 获取用户信息
     *
     * @param array $params
     * @return array
     */
    public function getUserInfo(array $params): array
    {
        $where = [
            ['account', '=', $params['account']],
            ['delete_time', '=', BaseModel::$defaultTime]
        ];

        return FactoryModel::getModel('User')->info('id,password', $where);
    }

    /**
     * 验证密码
     *
     * @param string $password
     * @param string $oldPassword
     * @return bool
     */
    public function passwordVerify(string $password, string $oldPassword): bool
    {
        return password_verify($password, $oldPassword);
    }
}