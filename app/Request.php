<?php

namespace app;

// 应用请求对象类
class Request extends \think\Request
{
    /**
     * 兼容PATH_INFO获取
     * @var array
     */
    protected $pathinfoFetch = ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL', 'REQUEST_URI'];

    /**
     * 请求参数
     *
     * @var array
     */
    private array $params = [];

    /**
     * 请求ID
     *
     * @var string
     */
    private string $requestId = '';

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

    /**
     * 生成请求ID
     *
     * @return string
     */
    public function generateRequestId(): string
    {
        $chars = md5(uniqid((string)mt_rand(), true));

        $requestId = substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);

        return strtoupper($requestId);
    }

    /**
     * 获取请求ID
     *
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * 设置请求ID
     *
     * @param string $requestId
     * @return void
     */
    public function setRequestId(string $requestId): void
    {
        $this->requestId = $requestId;
    }
}
