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


$connection = new Jahudka\MPD\Bridges\Native\Connection($config['connection']);
$client = new Jahudka\MPD\Client($connection, $config['options']);


$client
    ->clear()
    ->then(function() use ($client) {
        return $client->add('I am OK/Unknown Album/OK.mp3');
    })
    ->then($client->command('toggleRepeat', false))
    ->then($client->command('toggleRandom', false))
    ->then($client->play)
    ->then($client->getStatus)
    ->then(function($status) {
        foreach ($status as $k => $v) {
            echo $k . ': ' . $v . "\n";
        }

        exit(0);

    }, function($err) {
        if ($err instanceof \Exception) {
            echo $err->getMessage() . "\n";
        } else {
            echo "Unknown error\n";
        }

        exit(-1);

    });


while (true) {
    usleep(100000); // sleep 100 ms
    $connection->receive(); // and see if there's any new data

}
