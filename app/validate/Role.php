<?php
declare (strict_types = 1);

namespace app\validate;

use app\BaseValidate;

class Role extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id'        => ['require', 'integer', 'max' => 11],
        'name'      => ['require', 'max' => 50],
        'rules'     => ['require', 'max' => 65535],
        'status'    => ['require', 'integer', 'max' => 4],
        'page'      => ['integer', 'max' => 11],
        'list_rows' => ['integer', 'max' => 11]
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'id.require'        => '数据标识必须',
        'id.integer'        => '数据标识数据格式不正确',
        'id.max'            => '数据标识长度最大为11',
        'name.require'      => '角色名称必须',
        'name.max'          => '角色名称长度最大为50',
        'rules.require'     => '权限集合必须',
        'rules.max'         => '权限集合长度最大为65535',
        'status.require'    => '状态必须',
        'status.integer'    => '状态数据格式不正确',
        'status.max'        => '状态长度最大为4',
        'page.integer'      => '第几页数据格式不正确',
        'page.max'          => '第几页长度最大为11',
        'list_rows.integer' => '每页数据条数数据格式不正确',
        'list_rows.max'     => '每页数据条数长度最大为11'
    ];

    /**
     * 定义验证场景
     * 格式：'场景名' =>  ['字段名1','字段名2'...]
     *
     * @var array[]
     */
    protected $scene = [
        'info'   => ['id'],
        'add'    => ['name', 'rules', 'status'],
        'update' => ['id', 'name', 'rules', 'status'],
        'delete' => ['id']
    ];

    /**
     * list 验证场景定义
     *
     * @return Role
     */
    public function sceneList(): Role
    {
        return $this->remove('id', true)
            ->remove('name', 'require')
            ->remove('rules', 'require')
            ->remove('status', 'require');
    }
}
