<?php

namespace controller;

use app\controller\User;
use HttpCase;

class UserTest extends HttpCase
{
    /**
     * 获取资源列表
     *
     * @return void
     */
    public function testGet()
    {
        /*** @see User::list() */
        $response = $this->get('/user/list?page=1&list_rows=10', [], ['token' => $this->token]);

        $data = $response->getData();
        $this->assertEquals('success', $data['msg']);
    }

    /**
     * 获取资源信息
     * @depends testPost
     *
     * @return void
     */
    public function testInfo(int $id)
    {
        /*** @see User::info() */
        $response = $this->get('/user/info?id=' . $id, [], ['token' => $this->token]);

        $data = $response->getData();
        $this->assertEquals('success', $data['msg']);
    }

    /**
     * 新建资源
     * @return void
     */
    public function testPost()
    {
        /*** @see User::add() */
        $response = $this->post('/user/add', [
            'account'  => 'test' . uniqid(),
            'password' => password_hash('test' . uniqid(), PASSWORD_DEFAULT),
            'mobile'   => '131' . rand(10000000, 99999999),
            'email'    => '131' . rand(10000000, 99999999) . '@qq.com',
            'roles'    => '1,2,3',
            'status'   => 1
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
        /*** @see User::update() */
        $response = $this->put('/user/update', [
            'id'       => $id,
            'account'  => 'test' . uniqid(),
            'password' => password_hash('test' . uniqid(), PASSWORD_DEFAULT),
            'mobile'   => '131' . rand(10000000, 99999999),
            'email'    => '131' . rand(10000000, 99999999) . '@qq.com',
            'roles'    => '1,2,3',
            'status'   => 1
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
        /*** @see User::delete() */
        $response = $this->delete('/user/delete', [
            'id' => $id
        ], [
            'token'        => $this->token,
            'Content-Type' => 'application/json; charset=utf-8'
        ]);

        $data = $response->getData();
        $this->assertEquals('success', $data['msg']);
    }
}
