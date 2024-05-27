<?php

namespace app\server;

use app\BaseModel;
use app\FactoryModel;

class RegisterServer
{
    /**
     * 检测用户是否存在
     *
     * @param array $params
     * @return bool
     */
    public function isExistsUser(array $params): bool
    {
        $where = [
            ['account', '=', $params['account']],
            ['delete_time', '=', BaseModel::$defaultTime]
        ];

        $userInfo = FactoryModel::getModel('User')->info('id', $where);
        return !empty($userInfo);
    }

    /**
     * 创建用户
     *
     * @param array $params
     * @return int
     */
    public function createUser(array $params): int
    {
        $data = [
            'account'  => $params['account'],
            'password' => password_hash($params['password'], PASSWORD_DEFAULT),
            'mobile'   => $params['mobile'],
            'email'    => $params['email']
        ];

        return FactoryModel::getModel('User')->add($data, true);
    }
}