<?php

use PHPUnit\Framework\TestCase;
use think\App;
use think\Response;

class HttpCase extends TestCase
{
    /**
     * @var App
     */
    public App $app;

    /**
     * @var string
     */
    protected string $token = 'n4oVQj1/P3RqiJTZG5Tl4o+armZ163T6jpoIEkylBNVsQ9ZBWeDAf7xw3F46QnbvHYPWLNPSe11uq47Don2EJZAroLVAxs6wR/zikQ8AbI+6JdDIYoRBR1LakC08fIQew+QC4D/mEK5bO4YNQQF0+1qNl97vrAJUPpyiMoT5AOtF5gXm02/0xF+42zMbn1P/F8KCK5FwLJGiax05Ay7O0ybMp0+WOxsD98OB0d0aE+poJ8TPztNACB8FyWL3fa8OdyMBzQ4ft8rL5Kpzpag3aU5OkEf3kerq708g21A6YwU7yDN3WsuuwJl4JhpyPJy/HU0ufJvgAsHX+7n5j4vfmg==';

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->app = new App();
    }

    /**
     * 模拟get请求
     *
     * @param string $url
     * @param array $data
     * @param array $header
     * @return Response
     */
    protected function get(string $url, array $data = [], array $header = []): Response
    {
        // 解析链接中的参数
        $urlInfo = parse_url($url);
        if (!empty($urlInfo['query'])) {
            $queryList = explode('&', $urlInfo['query']);
            foreach ($queryList as $queryInfo) {
                [$field, $value] = explode('=', $queryInfo);
                $data[$field] = $value;
            }
        }

        $request = $this->app->request
            ->setMethod('get')
            ->withServer(['REQUEST_URI' => $url])
            ->withGet($data)
            ->withHeader($header);

        $response = $this->app->http->run($request);
        $this->app->http->end($response);

        return $response;
    }

    /**
     * 模拟post请求
     *
     * @param string $url
     * @param array $data
     * @param array $header
     * @return Response
     */
    protected function post(string $url, array $data = [], array $header = []): Response
    {
        $request = $this->app->request
            ->setMethod('post')
            ->withServer(['REQUEST_URI' => $url])
            ->withPost($data)
            ->withHeader($header);

        $response = $this->app->http->run($request);
        $this->app->http->end($response);

        return $response;
    }

    /**
     * 模拟put请求
     *
     * @param string $url
     * @param array $data
     * @param array $header
     * @return Response
     */
    protected function put(string $url, array $data = [], array $header = []): Response
    {
        $request = $this->app->request
            ->withHeader($header)
            ->setMethod('put')
            ->withServer(['REQUEST_URI' => $url])
            ->withInput(json_encode($data));

        $response = $this->app->http->run($request);
        $this->app->http->end($response);

        return $response;
    }

    /**
     * 模拟delete请求
     *
     * @param string $url
     * @param array $data
     * @param array $header
     * @return Response
     */
    protected function delete(string $url, array $data = [], array $header = []): Response
    {
        $request = $this->app->request
            ->withHeader($header)
            ->setMethod('delete')
            ->withServer(['REQUEST_URI' => $url])
            ->withInput(json_encode($data));

        $response = $this->app->http->run($request);
        $this->app->http->end($response);

        return $response;
    }
}