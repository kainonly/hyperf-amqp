<?php
declare(strict_types=1);

namespace Hyperf\AMQPClient;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Pool\SimplePool\PoolFactory;
use InvalidArgumentException;
use simplify\amqp\AMQPClient;
use stdClass;

class AMQPClientService
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get(ConfigInterface::class);
        $options = $config->get('amqp');
        $clients = new stdClass();
        foreach ($options['clients'] as $name) {
            if (empty($options[$name])) {
                throw new InvalidArgumentException("The [$name] does not exist.");
            }
            $option = $options[$name];
            /**
             * @var PoolFactory $factory
             */
            $factory = $container->get(PoolFactory::class);
            $pool = $factory->get("amqp-$name-pool", function () use ($option) {
                return new AMQPClient(
                    $option['host'],
                    (int)$option['port'],
                    $option['user'],
                    $option['password'],
                    $option['vhost'] ?? '/',
                    $option['params'] ?? []
                );
            }, $option['pool']);
            $clients->$name = $pool->get()->getConnection();
        }
        return make(AMQPClientFactory::class, [
            $clients
        ]);
    }
}