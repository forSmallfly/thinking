<?php
// 事件定义文件
use app\listener\AddRequestLog;
use app\listener\AddResponseLog;
use app\listener\SetRequestId;

return [
    'bind'      => [
    ],
    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [
            SetRequestId::class,
            AddRequestLog::class
        ],
        'HttpEnd'  => [
            AddResponseLog::class
        ],
        'LogLevel' => [],
        'LogWrite' => [],
    ],
    'subscribe' => [
    ],
];
