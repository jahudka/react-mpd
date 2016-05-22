<?php


namespace Jahudka\MPD\Connection;


use Jahudka\MPD\ConnectionInterface;
use Jahudka\MPD\Exception;
use React\Promise\PromiseInterface;
use React\Promise;

class Native implements ConnectionInterface {

    /** @var array */
    public static $defaults = [
        'host' => '127.0.0.1',
        'port' => 6600,
        'socket' => null,
    ];

    /** @var resource */
    private $sock = null;

    /** @var array */
    private $options;

    /** @var callable[] */
    private $dataHandlers = [];


    /**
     * Connection constructor.
     * @param array $options
     */
    public function __construct(array $options = []) {
        $this->options = $options + static::$defaults;

    }


    /**
     * @param string $data
     * @return PromiseInterface
     * @throws Exception
     */
    public function send($data) {
        try {
            $this->connect();
            stream_set_blocking($this->sock, true);
            fwrite($this->sock, $data);
            return Promise\resolve();

        } catch (\Exception $e) {
            return Promise\reject($e);

        }
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
     * @return resource
     * @throws Exception
     */
    public function getSocket() {
        $this->connect();
        return $this->sock;

    }

    /**
     * @return $this
     */
    public function receive() {
        if ($this->sock) {
            stream_set_blocking($this->sock, false);
            $data = '';

            while (($line = fgets($this->sock)) !== false) {
                $data .= $line;

            }

            if ($data) {
                foreach ($this->dataHandlers as $handler) {
                    call_user_func($handler, $data);

                }
            }
        }

        return $this;

    }

    /**
     * @throws Exception
     */
    protected function connect() {
        if (!$this->sock) {
            if (!empty($this->options['socket'])) {
                $uri = 'unix://' . $this->options['socket'];

            } else {
                $uri = 'tcp://';

                if (filter_var($this->options['host'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    $uri .= '[' . $this->options['host'] . ']';

                } else {
                    $uri .= $this->options['host'];

                }

                $uri .= ':' . $this->options['port'];

            }

            $this->sock = @stream_socket_client($uri, $errno, $errstr);

            if (!$this->sock) {
                throw new Exception($errstr, $errno);

            }

            $handshake = fread($this->sock, 1024);

            if (!preg_match('/^ok\b/i', $handshake)) {
                throw new Exception($handshake);

            }
        }
    }

}
