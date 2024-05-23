<?php
declare (strict_types = 1);

namespace app\middleware;

use app\BaseValidate;
use app\exceptions\ParamValidateException;
use app\exceptions\ValidateNotFoundException;
use app\exceptions\ValidateSceneUndefinedException;
use Closure;
use app\Request;
use think\Response;

/**
 * 请求参数验证中间件
 */
class ParamValidate
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 获取验证类
        $validateClass = $this->getValidateClass($request);
        if (!class_exists($validateClass)) {
            throw new ValidateNotFoundException($validateClass);
        }

        // 获取验证对象
        $validate = $this->getValidateObj($validateClass);
        $scene    = $request->action();
        if (!$validate->hasScene($scene)) {
            throw new ValidateSceneUndefinedException($validateClass, $scene);
        }

        // 获取请求参数
        $params = $this->getParams($request);
        if (!$validate->scene($scene)->check($params)) {
            throw new ParamValidateException($validate->getError());
        }

        // 过滤请求参数
        $params = $this->filterParams($scene, $validate, $params);

        // 将过滤后的请求参数设置到请求类
        $request->setParams($params);

        return $next($request);
    }

    /**
     * 获取验证类
     *
     * @param Request $request
     * @return string
     */
    private function getValidateClass(Request $request): string
    {
        return app()->getNamespace() . '\\validate\\' . $request->controller();
    }

    /**
     * 获取验证对象
     *
     * @param string $validateClass
     * @return BaseValidate
     */
    private function getValidateObj(string $validateClass): BaseValidate
    {
        return new $validateClass;
    }

    /**
     * 获取请求参数
     *
     * @param Request $request
     * @return array
     */
    private function getParams(Request $request): array
    {
        $method = strtolower($request->method());
        return match ($method) {
            'get' => $request->get(),
            'post' => $request->post(),
            'put' => $request->put(),
            'delete' => $request->delete(),
            default => [],
        };
    }

    /**
     * 过滤请求参数
     *
     * @param string $scene
     * @param BaseValidate $validate
     * @param array $params
     * @return array
     */
    private function filterParams(string $scene, BaseValidate $validate, array $params): array
    {
        // 获取定义的验证规则
        $ruleList = $validate->getRuleList();

        // 获取定义的验证场景列表
        $sceneList = $validate->getSceneList();

        // 验证场景列表存在当前场景时，直接使用验证场景中的字段信息
        if (isset($sceneList[$scene])) {
            $fieldList = $sceneList[$scene];
        } else {
            // 获取场景需要验证的规则
            $onlyField = $validate->getOnly();
            // 有自定义验证场景时，有指定场景需要验证的字段，直接使用
            if (!empty($onlyField)) {
                $fieldList = $onlyField;
            } else {
                // 没有指定场景需要验证的字段
                $ruleKeyList = array_keys($ruleList);

                // 剔除移除的字段
                $removeList = $validate->scene($scene)->getRemove();
                if (!empty($removeList)) {
                    foreach ($ruleKeyList as $key => $fieldName) {
                        if (isset($removeList[$fieldName]) && $removeList[$fieldName] === true) {
                            unset($ruleKeyList[$key]);
                        }
                    }
                }

                // 添加新增的字段
                $appendList = $validate->scene($scene)->getAppend();
                if (!empty($appendList)) {
                    $appendKeyList = array_keys($appendList);
                    $ruleKeyList   = array_merge($ruleKeyList, $appendKeyList);
                }

                $fieldList = array_values($ruleKeyList);
            }
        }

        // 请求参数数据类型转换
        foreach ($params as $filedName => $value) {
            // 字段有规定数字类型进行数据类型转换
            if (!empty($ruleList[$filedName]) && in_array('integer', $ruleList[$filedName])) {
                $params[$filedName] = (int)$value;
            }
        }

        // 过滤请求参数字段
        return array_filter($params, function ($filedName) use ($fieldList) {
            return in_array($filedName, $fieldList);
        }, ARRAY_FILTER_USE_KEY);
    }
}
