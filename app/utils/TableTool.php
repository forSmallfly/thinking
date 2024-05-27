<?php

namespace app\utils;

use think\facade\Db;
use think\helper\Str;

/**
 * 数据表工具库
 */
trait TableTool
{
    /**
     * 获取完整表名
     *
     * @param string $itemName
     * @return string
     */
    private function getTableName(string $itemName): string
    {
        $prefix = Db::connect()->getConfig('prefix');

        return $prefix . Str::snake($itemName);
    }

    /**
     * 获取表列表
     *
     * @return array
     */
    private function getTableList(): array
    {
        return Db::connect()->query("SHOW TABLES");
    }

    /**
     * 检测表是否存在
     *
     * @param string $table
     * @return bool
     */
    private function isExistsTable(string $table): bool
    {
        $list = Db::connect()->query("SHOW TABLES LIKE '{$table}'");

        return !empty($list);
    }

    /**
     * 获取表的字段信息
     *
     * @param $tableName
     * @return array
     */
    private function getTableFields($tableName): array
    {
        return Db::getfields($tableName);
    }
}