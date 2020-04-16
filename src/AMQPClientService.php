<?php
declare(strict_types=1);

namespace Hyperf\AMQPClient;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;

class AMQPClientService
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get(ConfigInterface::class);
        $options = $config->get('amqp');
        return make(AMQPClientFactory::class, [
            $options
        ]);
    }
}