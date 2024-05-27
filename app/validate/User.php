<?php
declare (strict_types = 1);

namespace app\validate;

use app\BaseValidate;

class User extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id'        => ['require', 'integer', 'max' => 11],
        'account'   => ['require', 'max' => 50],
        'password'  => ['require', 'max' => 255],
        'mobile'    => ['require', 'mobile'],
        'email'     => ['require', 'email'],
        'roles'     => ['require', 'max' => 255],
        'status'    => ['require', 'integer', 'max' => 3],
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
        'account.require'   => '用户名必须',
        'account.max'       => '用户名长度最大为50',
        'password.require'  => '密码必须',
        'password.max'      => '密码长度最大为255',
        'mobile.require'    => '手机号必须',
        'mobile.mobile'     => '手机号格式不正确',
        'email.require'     => '邮箱必须',
        'email.email'       => '邮箱格式不正确',
        'roles.require'     => '角色集合必须',
        'roles.max'         => '角色集合长度最大为255',
        'status.require'    => '状态必须',
        'status.integer'    => '状态数据格式不正确',
        'status.max'        => '状态长度最大为3',
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
        'add'    => ['account', 'password', 'mobile', 'email', 'roles', 'status'],
        'update' => ['id', 'account', 'password', 'mobile', 'email', 'roles', 'status'],
        'delete' => ['id']
    ];

    /**
     * list 验证场景定义
     *
     * @return User
     */
    public function sceneList(): User
    {
        return $this->remove('id', true)
            ->remove('account', 'require')
            ->remove('password', 'require')
            ->remove('mobile', 'require')
            ->remove('email', 'require')
            ->remove('roles', 'require')
            ->remove('status', 'require');
    }
}
