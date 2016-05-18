<?php


namespace Jahudka\MPD;

use React\Promise\PromiseInterface;


interface ConnectionInterface {

    /**
     * @param $data
     * @return PromiseInterface
     */
    public function send($data);


    /**
     * @param callable $handler
     * @return ConnectionInterface
     */
    public function onReceive(callable $handler);

}
