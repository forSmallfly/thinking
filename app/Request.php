<?php

namespace app;

// 应用请求对象类
class Request extends \think\Request
{
    /**
     * 请求参数
     *
     * @var array
     */
    private array $params = [];

    /**
     * 获取请求参数
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * 设置请求参数
     *
     * @param array $params
     * @return void
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }
}
