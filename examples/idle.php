<?php


require __DIR__ . '/../vendor/autoload.php';

$config = [
    'connection' => [
        'host' => '127.0.0.1',
        'port' => 6600,
        'socket' => '/run/mpd/socket',
    ],
    'options' => [
        'password' => null,
    ],
];


$loop = React\EventLoop\Factory::create();
$connection = new Jahudka\MPD\Connection\React($loop, $config['connection']);
$client = new Jahudka\MPD\Client($connection, $config['options']);


$loop->nextTick(function () use ($client) {
    $client->on('update', function($subsystem) {
        echo "Update: $subsystem\n";
    });

    $client->idle(Jahudka\MPD\Client::SUBSYSTEM_PLAYER);

});

// even if the client is in idle mode & listening for server events,
// you can still use the API - the client will transparently exit
// idle mode, issue your commands and then resume being idle
$loop->addTimer(10, function () use ($client) {
    echo "Playing song\n";

    $client->batch()
        ->clear()
        ->add('Path/To/Song.mp3')
        ->play()
        ->run();
});

$loop->run();
