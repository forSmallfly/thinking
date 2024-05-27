<?php

namespace app;

use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;

class BaseModel extends Model
{
    /**
     * 默认时间
     *
     * @var string
     */
    public static string $defaultTime = '0000-00-00 00:00:00';

    /**
     * 默认页码
     *
     * @var int
     */
    protected int $page = 1;

    /**
     * 默认每页数据量
     *
     * @var int
     */
    protected int $listRows = 15;

    /**
     * 设置分页信息
     *
     * @param array $params
     * @return BaseModel
     */
    public function setPageAndListRows(array $params): BaseModel
    {
        if (!empty($params['page'])) {
            $this->page = $params['page'];
        }

        if (!empty($params['list_rows'])) {
            $this->listRows = $params['list_rows'];
        }

        return $this;
    }

    /**
     * 获取资源列表
     *
     * @param string $field
     * @param array $where
     * @param array $order
     * @return array
     * @throws DbException
     */
    public function tableList(string $field, array $where = [], array $order = []): array
    {
        $total = $this->total($where);
        $list  = $this->list($field, $where, $order);

        return [$total, $list];
    }

    /**
     * 获取数据总数
     *
     * @param array $where
     * @return int
     * @throws DbException
     */
    public function total(array $where): int
    {
        return $this->where($where)->count();
    }

    /**
     * 获取资源列表
     *
     * @param string $field
     * @param array $where
     * @param array $order
     * @param bool $isExport
     * @return array
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function list(string $field, array $where = [], array $order = [], bool $isExport = false): array
    {
        // 导出数据时不进行分页
        if ($isExport) {
            $list = $this->field($field)->where($where)->order($order)->failException(false)->select()->toArray();
        } else {
            $list = $this->field($field)->where($where)->page($this->page, $this->listRows)->order($order)->failException(false)->select()->toArray();
        }

        return $list;
    }

    /**
     * 获取资源指定字段列表
     *
     * @param string $field
     * @param array $where
     * @param string $key
     * @return array
     */
    public function fieldList(string $field, array $where = [], string $key = ''): array
    {
        return $this->where($where)->column($field, $key);
    }

    /**
     * 显示指定的资源
     *
     * @param string $field
     * @param array $where
     * @return array
     */
    public function info(string $field, array $where): array
    {
        return $this->field($field)->where($where)->findOrEmpty()->toArray();
    }

    /**
     * 显示指定资源的指定字段信息
     *
     * @param string $field
     * @param array $where
     * @return mixed
     */
    public function fieldInfo(string $field, array $where): mixed
    {
        return $this->where($where)->value($field);
    }

    /**
     * 保存新建的资源
     *
     * @param array $data
     * @param bool $getLastInsID
     * @return int|string
     */
    public function add(array $data, bool $getLastInsID = false): int|string
    {
        return $this->insert($data, $getLastInsID);
    }

    /**
     * 批量保存新建的资源
     *
     * @param array $data
     * @return int
     */
    public function batchAdd(array $data): int
    {
        return $this->insertAll($data);
    }

    /**
     * 保存更新的资源
     *
     * @param array $where
     * @param array $data
     * @return bool
     */
    public function change(array $where, array $data): bool
    {
        return $this->where($where)->save($data);
    }

    /**
     * 删除指定资源
     *
     * @param array $where
     * @param bool $isSoftDelete
     * @return bool
     */
    public function remove(array $where, bool $isSoftDelete = true): bool
    {
        if ($isSoftDelete) {
            $where[] = ['delete_time', '=', self::$defaultTime];
            return $this->where($where)->save([
                'delete_time' => date('Y-m-d H:i:s')
            ]);
        } else {
            return $this->where($where)->delete();
        }
    }
}