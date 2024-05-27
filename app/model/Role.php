<?php
declare (strict_types = 1);

namespace app\model;

use app\BaseModel;

class Role extends BaseModel
{
    /**
     * 获取角色拥有的权限ID列表
     *
     * @param int|array $roleId
     * @return array
     */
    public function getRuleIdList(int|array $roleId): array
    {
        $where[] = is_array($roleId) ? ['id', 'in', $roleId] : ['id', '=', $roleId];
        $where[] = ['delete_time', '=', BaseModel::$defaultTime];

        $list = $this->fieldList('rules', $where);
        if (empty($list)) {
            return [];
        }

        $ruleIdList = [];
        foreach ($list as $rules) {
            if (empty($rules)) {
                continue;
            }

            $rules      = explode(',', $rules);
            $ruleIdList = array_merge($ruleIdList, $rules);
        }

        return $ruleIdList;
    }
}
