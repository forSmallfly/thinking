<?php
declare (strict_types = 1);

namespace app\validate;

use app\BaseValidate;

class Rule extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id'        => ['require', 'integer', 'max' => 11],
        'pid'       => ['require', 'integer', 'max' => 10],
        'type'      => ['require', 'integer', 'max' => 3],
        'name'      => ['require', 'max' => 50],
        'url'       => ['require', 'max' => 255],
        'sort'      => ['require', 'integer', 'max' => 3],
        'page'      => ['require', 'integer', 'max' => 11],
        'list_rows' => ['require', 'integer', 'max' => 11]
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
        'pid.require'       => '上级ID必须',
        'pid.integer'       => '上级ID数据格式不正确',
        'pid.max'           => '上级ID长度最大为10',
        'type.require'      => '类型必须',
        'type.integer'      => '类型数据格式不正确',
        'type.max'          => '类型长度最大为3',
        'name.require'      => '权限名称必须',
        'name.max'          => '权限名称长度最大为50',
        'url.require'       => '权限链接必须',
        'url.max'           => '权限链接长度最大为255',
        'sort.require'      => '排序必须',
        'sort.integer'      => '排序数据格式不正确',
        'sort.max'          => '排序长度最大为3',
        'page.require'      => '第几页必须',
        'page.integer'      => '第几页数据格式不正确',
        'page.max'          => '第几页长度最大为11',
        'list_rows.require' => '每页数据条数必须',
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
        'add'    => ['pid', 'type', 'name', 'url', 'sort'],
        'update' => ['id', 'pid', 'type', 'name', 'url', 'sort'],
        'delete' => ['id']
    ];

    /**
     * list 验证场景定义
     *
     * @return Rule
     */
    public function sceneList(): Rule
    {
        return $this->remove('id', true)
            ->remove('pid', 'require')
            ->remove('type', 'require')
            ->remove('name', 'require')
            ->remove('url', 'require')
            ->remove('sort', 'require');
    }
}
