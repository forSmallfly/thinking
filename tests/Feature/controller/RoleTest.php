<?php

namespace controller;

use app\controller\Role;
use HttpCase;

class RoleTest extends HttpCase
{
    /**
     * 获取资源列表
     *
     * @return void
     */
    public function testGet()
    {
        /*** @see Role::list() */
        $response = $this->get('/role/list?page=1&list_rows=10', [], ['token' => $this->token]);

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
        /*** @see Role::info() */
        $response = $this->get('/role/info?id=1', [], ['token' => $this->token]);

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
        /*** @see Role::add() */
        $response = $this->post('/role/add', [
            'name'   => uniqid(),
            'rules'  => implode(',', range(1, 10)),
            'status' => 1
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
        /*** @see Role::update() */
        $response = $this->put('/role/update', [
            'id'     => $id,
            'rules'  => implode(',', range(1, 10)),
            'name'   => uniqid(),
            'status' => 1
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
        /*** @see Role::delete() */
        $response = $this->delete('/role/delete', [
            'id' => $id
        ], [
            'token'        => $this->token,
            'Content-Type' => 'application/json; charset=utf-8'
        ]);

        $data = $response->getData();
        $this->assertEquals('success', $data['msg']);
    }
}