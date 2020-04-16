<?php
declare(strict_types=1);

namespace Hyperf\AMQPClient;

use Closure;

interface AMQPClientInterface
{
    /**
     * 创建信道
     * @param Closure $closure
     * @param string $name 配置标识
     */
    public function channel(Closure $closure, string $name = 'default'): void;

    /**
     * 创建事务信道
     * @param Closure $closure
     * @param string $name 配置标识
     */
    public function channeltx(Closure $closure, string $name = 'default'): void;
}