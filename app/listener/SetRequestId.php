<?php
declare (strict_types = 1);

namespace app\listener;

class SetRequestId
{
    /**
     * 设置请求ID
     *
     * @return void
     */
    public function handle(): void
    {
        // 设置请求ID
        $requestId = getRequest()->generateRequestId();
        getRequest()->setRequestId($requestId);
    }
}
