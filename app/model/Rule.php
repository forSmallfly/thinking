<?php
declare (strict_types = 1);

namespace app\model;

use app\BaseModel;

class Rule extends BaseModel
{
    /**
     * 根据URL获取权限ID
     *
     * @param string $url
     * @return int
     */
    public function getRuleIdFromUrl(string $url): int
    {
        $where = [
            ['url', '=', $url],
            ['delete_time', '=', BaseModel::$defaultTime]
        ];

        return $this->fieldInfo('id', $where);
    }
}
