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
    protected string $token = 'F/gNAcosUUJx6LplwF8ekuYVmCBkPweCQmSEhdnIvYigZQFF/05NOqzYftU98ulko+0G6A32GTtYu4f8Sbligaxjz6OQd/6i49sh4rW6IHxnLzazfWDYBrtb5lL+99mEJt8L3WisXOIxoQb9XzgGZMJG3xdByEcqtIc1swhFeVRjlyECs8XFYUNzwzn3u9o2oxj6c05xmnP8KgzucPvmi3W1gIWrtSDapwBU/VigS8JRY9wFxjnqYdY6TtFC/KfuoLfaGI+CkiklI3HeGYA+ueSnwv1Supb4xOvqv0jBQDi2ezB7EssPS1ZbkWwAKtcgU550yMbsjV9iCWjqt6SZyA==';

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