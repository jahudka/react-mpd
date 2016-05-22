<?php


require __DIR__ . '/../vendor/autoload.php';

$config = [
    'connection' => [
        'host' => '127.0.0.1',
        'port' => 6600,
        'socket' => null,
    ],
    'options' => [
        'password' => null,
    ],
];


$loop = React\EventLoop\Factory::create();
$connection = new Jahudka\MPD\Connection\React($loop, $config['connection']);
$client = new Jahudka\MPD\Client($connection, $config['options']);


$loop->nextTick(function (React\EventLoop\LoopInterface $loop) use ($client) {
    $client
        ->clear()
        ->then(function() use ($client) {
            return $client->add('Path/To/Song.mp3');
        })
        ->then($client->command('toggleRepeat', false))
        ->then($client->command('toggleRandom', false))
        ->then($client->play)
        ->then($client->getStatus)
        ->then(function($status) use ($loop) {
            foreach ($status as $k => $v) {
                echo $k . ': ' . $v . "\n";
            }

            $loop->stop();

        }, function($err) use ($loop) {
            if ($err instanceof \Exception) {
                echo $err->getMessage() . "\n";
            } else {
                echo "Unknown error\n";
            }

            $loop->stop();

        });
});

$loop->run();
