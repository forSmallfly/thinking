<?php
declare (strict_types = 1);

namespace app\model;

use app\BaseModel;

class User extends BaseModel
{
    /**
     * 获取用户拥有的角色ID列表
     *
     * @param int $uid
     * @return array
     */
    public function getRoleIdList(int $uid): array
    {
        $where = [
            ['id', '=', $uid],
            ['delete_time', '=', BaseModel::$defaultTime]
        ];

        $info = $this->info('roles', $where);
        if (empty($info) || empty($info['roles'])) {
            return [];
        }

        return explode(',', $info['roles']);
    }
}
