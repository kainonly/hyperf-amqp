<?php
declare(strict_types=1);

namespace Hyperf\AMQPClient;

use Closure;
use Exception;
use simplify\amqp\AMQPClient;
use stdClass;

class AMQPClientFactory implements AMQPClientInterface
{
    /**
     * 客户端集合
     * @var stdClass
     */
    private stdClass $clients;

    /**
     * AMQPInstance constructor.
     * @param stdClass $clients
     */
    public function __construct(stdClass $clients)
    {
        $this->clients = $clients;
    }

    /**
     * @param string $name
     * @return AMQPClient
     */
    private function client(string $name): AMQPClient
    {
        return $this->clients->$name;
    }

    /**
     * @param Closure $closure
     * @param string $name
     * @param array $options
     * @throws Exception
     * @inheritDoc
     */
    public function channel(Closure $closure, string $name = 'default', array $options = []): void
    {
        $this->client($name)->channel($closure, $options);
    }

    /**
     * @param Closure $closure
     * @param string $name
     * @param array $options
     * @throws Exception
     * @inheritDoc
     */
    public function channeltx(Closure $closure, string $name = 'default', array $options = []): void
    {
        $this->client($name)->channeltx($closure, $options);
    }
}