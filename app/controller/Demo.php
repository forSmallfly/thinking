<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use app\BaseModel;
use app\FactoryModel;
use think\annotation\route\Route;
use think\db\exception\DbException;
use think\Response;

class Demo extends BaseController
{
    /**
     * 获取资源列表
     *
     * @return Response
     * @throws DbException
     */
    #[Route("GET", "demo/list")]
    public function list(): Response
    {
        $params = $this->request->getParams();
        $field  = '';
        $where  = [
            ['delete_time', '=', BaseModel::$defaultTime]
        ];
        // 设置分页信息
        [$total, $list] = FactoryModel::getModel('Demo')->setPageAndListRows($params)->tableList($field, $where);
        return $this->success([
            'total' => $total,
            'list'  => $list
        ]);
    }

    /**
     * 获取资源信息
     *
     * @return Response
     */
    #[Route("GET", "demo/info")]
    public function info(): Response
    {
        $params = $this->request->getParams();
        $field  = '';
        $where  = [
            ['id', '=', $params['id']],
            ['delete_time', '=', BaseModel::$defaultTime]
        ];

        $info = FactoryModel::getModel('Demo')->info($field, $where);
        return $this->success([
            'info' => $info
        ]);
    }

    /**
     * 新建资源
     *
     * @return Response
     */
    #[Route("POST", "demo/add")]
    public function add(): Response
    {
        $params = $this->request->getParams();
        $result = FactoryModel::getModel('Demo')->add($params, true);
        return $result ? $this->success(['id' => $result]) : $this->fail();
    }

    /**
     * 更新资源
     *
     * @return Response
     */
    #[Route("PUT", "demo/update")]
    public function update(): Response
    {
        $params = $this->request->getParams();
        $where  = [
            ['id', '=', $params['id']],
            ['delete_time', '=', BaseModel::$defaultTime]
        ];

        unset($params['id']);
        $result = FactoryModel::getModel('Demo')->change($where, $params);
        return $result ? $this->success() : $this->fail();
    }

    /**
     * 删除资源
     *
     * @return Response
     */
    #[Route("DELETE", "demo/delete")]
    public function delete(): Response
    {
        $params = $this->request->getParams();
        $where  = [
            ['id', '=', $params['id']]
        ];
        $result = FactoryModel::getModel('Demo')->remove($where);
        return $result ? $this->success() : $this->fail();
    }
}
