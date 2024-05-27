<?php

namespace app;

use think\helper\Str;

class FactoryModel
{
    /**
     * 实例集合
     *
     * @var array
     */
    private static array $instances = [];

    /**
     * @param string $model
     * @param bool $newInstance
     * @return BaseModel
     */
    public static function getModel(string $model, bool $newInstance = false): BaseModel
    {
        $class = app()->getNamespace() . '\\model\\' . Str::studly($model);
        if ($newInstance) {
            return app()->make($class);
        }

        if (empty(self::$instances[$class])) {
            self::$instances[$class] = app()->make($class);
        }

        return self::$instances[$class];
    }
}