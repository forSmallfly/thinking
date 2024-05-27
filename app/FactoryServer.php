<?php

namespace app;

use app\server\LoginServer;
use app\server\RegisterServer;

class FactoryServer
{
    /**
     * 实例集合
     *
     * @var array
     */
    private static array $instances = [];

    /**
     * @param bool $newInstance
     * @return LoginServer
     */
    public static function getLoginServer(bool $newInstance = false): LoginServer
    {
        if ($newInstance) {
            return new LoginServer();
        }

        $key = __FUNCTION__;
        if (empty(self::$instances[$key])) {
            self::$instances[$key] = new LoginServer();
        }

        return self::$instances[$key];
    }

    /**
     * @param bool $newInstance
     * @return RegisterServer
     */
    public static function getRegisterServer(bool $newInstance = false): RegisterServer
    {
        if ($newInstance) {
            return new RegisterServer();
        }

        $key = __FUNCTION__;
        if (empty(self::$instances[$key])) {
            self::$instances[$key] = new RegisterServer();
        }

        return self::$instances[$key];
    }
}