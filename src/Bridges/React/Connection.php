<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 16/05/16
 * Time: 16:17
 */

namespace Jahudka\MPD\Bridges\React;


use Jahudka\MPD\ConnectionInterface;
use React\EventLoop\LoopInterface;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use React\SocketClient\TcpConnector;
use React\SocketClient\UnixConnector;
use React\Stream\Stream;

class Connection implements ConnectionInterface {

    /** @var array */
    public static $defaults = [
        'host' => '127.0.0.1',
        'port' => 6600,
        'socket' => null,
    ];

    /** @var LoopInterface */
    protected $loop;

    /** @var array */
    protected $options;

    /** @var PromiseInterface */
    private $connection = null;

    /** @var Stream */
    private $io = null;

    /** @var callable[] */
    private $dataHandlers = [];



    /**
     * Connector constructor.
     * @param LoopInterface $loop
     * @param array $options
     */
    public function __construct(LoopInterface $loop, array $options = []) {
        $this->loop = $loop;
        $this->options = $options + static::$defaults;

    }

    /**
     * @param string $data
     * @return PromiseInterface
     */
    public function send($data) {
        return $this->getConnection()->then(function() use ($data) {
            $this->io->write($data);

        });
    }

    /**
     * @param callable $handler
     * @return $this
     */
    public function onReceive(callable $handler) {
        $this->dataHandlers[] = $handler;
        return $this;

    }

    /**
     * @return PromiseInterface
     */
    protected function getConnection() {
        if (!$this->connection) {
            if (!empty($this->options['socket'])) {
                $connector = new UnixConnector($this->loop);
                $connection = $connector->create($this->options['socket']);

            } else {
                $connector = new TcpConnector($this->loop);
                $connection = $connector->create($this->options['host'], $this->options['port']);

            }

            $this->connection = $connection->then([$this, 'handleInit']);

        }

        return $this->connection;

    }

    /**
     * @param Stream $stream
     * @return PromiseInterface
     */
    public function handleInit(Stream $stream) {
        $this->io = $stream;

        return new Promise(function(callable $fulfill, callable $reject) {
            $this->io->once('data', function($data) use ($fulfill, $reject) {
                if (preg_match('/^ok\b/i', $data)) {
                    $this->io->on('data', [$this, 'handleData']);
                    call_user_func($fulfill);

                } else {
                    call_user_func($reject, trim($data));

                }
            });
        });
    }

    /**
     * @param string $data
     */
    public function handleData($data) {
        foreach ($this->dataHandlers as $handler) {
            call_user_func($handler, $data);

        }
    }
}
