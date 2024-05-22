<?php

namespace controller;

use HttpCase;

class IndexTest extends HttpCase
{
    public function testIndex()
    {
        $response = $this->post('/');

        $this->assertEquals(200, $response->getCode());
        echo $response->getContent();
    }

    public function testHello()
    {
        $response = $this->get('/hello/world');

        $this->assertEquals(200, $response->getCode());
        echo $response->getContent();
        echo $response->getData();
    }
}