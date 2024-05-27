<?php

namespace utils;

use app\utils\RsaTool;
use PHPUnit\Framework\TestCase;

class RsaToolTest extends TestCase
{
    use RsaTool;

    public string $uid = '2';

    public function setUp(): void
    {
        app()->http->run();
    }

    /**
     * @return string
     */
    public function testEncryptRSA()
    {
        $token = $this->encryptRSA($this->uid);

        $this->assertIsString($token);
        return $token;
    }

    /**
     * @depends testEncryptRSA
     *
     * @return void
     */
    public function testDecryptRSA(string $token)
    {
        $uid = $this->decryptRSA($token);

        $this->assertEquals($this->uid, $uid);
    }
}
