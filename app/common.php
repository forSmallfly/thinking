<?php
// 应用公共文件
use app\Request;

if (!function_exists('getRequest')) {
    /**
     * 返回请求对象
     *
     * @return Request
     */
    function getRequest(): Request
    {
        return app()->make('request');
    }
}