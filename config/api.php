<?php
// +----------------------------------------------------------------------
// | API设置
// +----------------------------------------------------------------------
return [
    // API返回数据格式
    'return_data_type' => 'json',
    // API免登录名单
    'exempt_login'     => [
        'Common/login',
        'Common/register',
        'Index/hello',
    ],
    // API白名单
    'white_list'       => [
        'Common/logout'
    ]
];