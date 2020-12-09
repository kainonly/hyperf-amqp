<?php
declare(strict_types=1);

namespace Hyperf\AMQPClient;

use Closure;
use Exception;
use InvalidArgumentException;
use Simplify\AMQP\AMQPClient;
use Simplify\AMQP\AMQPManager;

class AMQP implements AMQPInterface
{
    /**
     * 配置集合
     * @var array
     */
    private array $options;

    /**
     * AMQPClientService constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @param string $name 配置标识
     * @return AMQPClient
     */
    public function client(string $name = 'default'): AMQPClient
    {
        if (empty($this->options[$name])) {
            throw new InvalidArgumentException("The [$name] does not exist.");
        }
        $option = $this->options[$name];
        return new AMQPClient(
            $option['host'],
            (int)$option['port'],
            $option['user'],
            $option['password'],
            $option['vhost'] ?? '/',
            $option['params'] ?? []
        );
    }

    /**
     * @param Closure $closure
     * @param string $name
     * @throws Exception
     * @inheritDoc
     */
    public function channel(Closure $closure, string $name = 'default'): void
    {
        $connection = $this->client($name)->getAMQPStreamConnection();
        $channel = $connection->channel();
        $closure(new AMQPManager($channel));
        $channel->close();
        $connection->close();
    }

    /**
     * @param Closure $closure
     * @param string $name
     * @throws Exception
     * @inheritDoc
     */
    public function channeltx(Closure $closure, string $name = 'default'): void
    {
        $connection = $this->client($name)->getAMQPStreamConnection();
        $channel = $connection->channel();
        $channel->tx_select();
        if ($closure(new AMQPManager($channel))) {
            $channel->tx_commit();
        } else {
            $channel->tx_rollback();
        }
        $channel->close();
        $connection->close();
    }
}