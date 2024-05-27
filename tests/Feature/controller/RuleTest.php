<?php

namespace controller;

use app\controller\Rule;
use HttpCase;

class RuleTest extends HttpCase
{
    /**
     * 获取资源列表
     *
     * @return void
     */
    public function testGet()
    {
        /*** @see Rule::list() */
        $response = $this->get('/rule/list?page=1&list_rows=10', [], ['token' => $this->token]);

        $data = $response->getData();
        $this->assertEquals('success', $data['msg']);
    }

    /**
     * 获取资源信息
     *
     * @return void
     */
    public function testInfo()
    {
        /*** @see Rule::info() */
        $response = $this->get('/rule/info?id=1', [], ['token' => $this->token]);

        $data = $response->getData();
        $this->assertEquals('success', $data['msg']);
    }

    /**
     * 新建资源
     *
     * @return void
     */
    public function testPost()
    {
        /*** @see Rule::add() */
        $response = $this->post('/rule/add', [
            'pid'  => 0,
            'type' => 1,
            'name' => uniqid(),
            'url'  => uniqid(),
            'sort' => rand(50, 150)
        ], ['token' => $this->token]);

        $data = $response->getData();
        $this->assertEquals('success', $data['msg']);

        return $data['data']['id'];
    }

    /**
     * 更新资源
     * @depends testPost
     *
     * @return void
     */
    public function testPut(int $id)
    {
        /*** @see Rule::update() */
        $response = $this->put('/rule/update', [
            'id'   => $id,
            'pid'  => 0,
            'type' => 1,
            'name' => uniqid(),
            'url'  => uniqid(),
            'sort' => rand(50, 150)
        ], [
            'token'        => $this->token,
            'Content-Type' => 'application/json; charset=utf-8'
        ]);

        $data = $response->getData();
        $this->assertEquals('success', $data['msg']);
    }

    /**
     * 删除资源
     * @depends testPost
     *
     * @return void
     */
    public function testDelete(int $id)
    {
        /*** @see Rule::delete() */
        $response = $this->delete('/rule/delete', [
            'id' => $id
        ], [
            'token'        => $this->token,
            'Content-Type' => 'application/json; charset=utf-8'
        ]);

        $data = $response->getData();
        $this->assertEquals('success', $data['msg']);
    }
}