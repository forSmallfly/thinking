<?php
// 事件定义文件
use app\listener\SetRequestId;

return [
    'bind'      => [
    ],
    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [
            SetRequestId::class
        ],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
    ],
    'subscribe' => [
    ],
];
