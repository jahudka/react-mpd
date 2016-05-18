<?php



namespace Jahudka\MPD;


use Evenement\EventEmitter;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;


/**
 * @property callable $clearLastError
 * @property callable $getCurrentSong
 * @property callable $getStatus
 * @property callable $getStats
 * @property callable $toggleConsume
 * @property callable $setCrossfadeLength
 * @property callable $setMixRampDb
 * @property callable $setMixRampDelay
 * @property callable $toggleRandom
 * @property callable $toggleRepeat
 * @property callable $setVolume
 * @property callable $toggleSingle
 * @property callable $setReplayGainMode
 * @property callable $getReplayGainStatus
 * @property callable $next
 * @property callable $togglePause
 * @property callable $play
 * @property callable $playSong
 * @property callable $seekSong
 * @property callable $stop
 * @property callable $previous
 * @property callable $seek
 * @property callable $add
 * @property callable $addSong
 * @property callable $clear
 * @property callable $remove
 * @property callable $removeSong
 * @property callable $move
 * @property callable $moveSong
 * @property callable $findInPlaylist
 * @property callable $getPlaylistSongInfo
 * @property callable $getPlaylistInfo
 * @property callable $getPlaylistChanges
 * @property callable $setPriority
 * @property callable $setSongPriority
 * @property callable $setSongRange
 * @property callable $shuffle
 * @property callable $swap
 * @property callable $swapSongs
 * @property callable $addSongTag
 * @property callable $clearSongTag
 * @property callable $clearSongTags
 * @property callable $getPlaylist
 * @property callable $loadPlaylist
 * @property callable $getPlaylists
 * @property callable $addToPlaylist
 * @property callable $clearPlaylist
 * @property callable $removeFromPlaylist
 * @property callable $moveInPlaylist
 * @property callable $renamePlaylist
 * @property callable $removePlaylist
 * @property callable $savePlaylist
 * @property callable $count
 * @property callable $find
 * @property callable $findAndAdd
 * @property callable $searchIntoPlaylist
 * @property callable $listTags
 * @property callable $listAll
 * @property callable $listFiles
 * @property callable $listInfo
 * @property callable $readComments
 * @property callable $update
 * @property callable $mount
 * @property callable $unmount
 * @property callable $listMounts
 * @property callable $listNeighbors
 * @property callable $getSticker
 * @property callable $setSticker
 * @property callable $removeSticker
 * @property callable $listStickers
 * @property callable $findStickers
 * @property callable $ping
 * @property callable $disableOutput
 * @property callable $enableOutput
 * @property callable $toggleOutput
 * @property callable $getOutputs
 * @property callable $getConfig
 * @property callable $getAvailableCommands
 * @property callable $getUnavailableCommands
 * @property callable $getTagTypes
 * @property callable $getUrlHandlers
 * @property callable $getDecoders
 * @property callable $subscribeToChannel
 * @property callable $unsubscribeFromChannel
 * @property callable $getChannels
 * @property callable $sendMessage
 * @property callable $readMessages
 * @method PromiseInterface clearLastError()
 * @method PromiseInterface toggleConsume(bool $state = true)
 * @method PromiseInterface setCrossfadeLength(float $length)
 * @method PromiseInterface setMixRampDb(float $db)
 * @method PromiseInterface setMixRampDelay(float $delay)
 * @method PromiseInterface toggleRandom(bool $state = true)
 * @method PromiseInterface toggleRepeat(bool $state = true)
 * @method PromiseInterface setVolume(int $volume)
 * @method PromiseInterface toggleSingle(bool $state = true)
 * @method PromiseInterface setReplayGainMode(string $mode)
 * @method PromiseInterface next()
 * @method PromiseInterface togglePause(bool $state = true)
 * @method PromiseInterface play(int $pos = null)
 * @method PromiseInterface playSong(int $id)
 * @method PromiseInterface seekSong(int $id, float $time = 0)
 * @method PromiseInterface stop()
 * @method PromiseInterface previous()
 * @method PromiseInterface seek(int $song, float $time)
 * @method PromiseInterface add(string $uri)
 * @method PromiseInterface clear()
 * @method PromiseInterface remove(int $pos, int|bool $end = null)
 * @method PromiseInterface removeSong(int $id)
 * @method PromiseInterface move(int $pos, int|bool $end, int $to)
 * @method PromiseInterface moveSong(int $id, int $to)
 * @method PromiseInterface getPlaylistChanges(int $version, int $start = null, int|bool $end = true)
 * @method PromiseInterface setPriority(int $priority, int $start, int|bool $end = true)
 * @method PromiseInterface setSongPriority(int $priority, int $id)
 * @method PromiseInterface setSongRange(int $id, float $start = null, float|bool $end = null)
 * @method PromiseInterface shuffle(int $start = null, int|bool $end = null)
 * @method PromiseInterface swap(int $a, int $b)
 * @method PromiseInterface swapSongs(int $a, int $b)
 * @method PromiseInterface addSongTag(int $id, string $tag, string $value)
 * @method PromiseInterface clearSongTag(int $id, string $tag)
 * @method PromiseInterface clearSongTags(int $id)
 * @method PromiseInterface loadPlaylist(string $name, int $start = null, int|bool $end = null)
 * @method PromiseInterface addToPlaylist(string $name, string $uri)
 * @method PromiseInterface clearPlaylist(string $name)
 * @method PromiseInterface removeFromPlaylist(string $name, int $pos)
 * @method PromiseInterface moveInPlaylist(string $name, int $from, int $to)
 * @method PromiseInterface renamePlaylist(string $name, string $newName)
 * @method PromiseInterface removePlaylist(string $name)
 * @method PromiseInterface savePlaylist(string $name)
 * @method PromiseInterface count(array $criteria, string $group = null)
 * @method PromiseInterface find(array $criteria, bool $cs = false, int $start = null, int|bool $end = null)
 * @method PromiseInterface findAndAdd(array $criteria, bool $cs = false)
 * @method PromiseInterface searchIntoPlaylist(string $name, array $criteria)
 * @method PromiseInterface readComments(string $uri = null)
 * @method PromiseInterface update(string $uri = null, bool $force = false)
 * @method PromiseInterface mount(string $path, string $uri)
 * @method PromiseInterface unmount(string $path)
 * @method PromiseInterface getSticker(string $type, string $uri, string $name)
 * @method PromiseInterface setSticker(string $type, string $uri, string $name, string $value)
 * @method PromiseInterface removeSticker(string $type, string $uri, string $name = null)
 * @method PromiseInterface listStickers(string $type, string $uri)
 * @method PromiseInterface findStickers(string $type, string $uri, string $name, string $value = null, string $op = "=")
 * @method PromiseInterface ping()
 * @method PromiseInterface disableOutput(int $id)
 * @method PromiseInterface enableOutput(int $id)
 * @method PromiseInterface toggleOutput(int $id)
 * @method PromiseInterface subscribeToChannel(string $name)
 * @method PromiseInterface unsubscribeFromChannel(string $name)
 * @method PromiseInterface sendMessage(string $channel, string $message)
 */
class Client extends EventEmitter {

    const SUBSYSTEM_DATABASE = 'database',
        SUBSYSTEM_UPDATE = 'update',
        SUBSYSTEM_STORED_PLAYLIST = 'stored_playlist',
        SUBSYSTEM_PLAYLIST = 'playlist',
        SUBSYSTEM_PLAYER = 'player',
        SUBSYSTEM_MIXER = 'mixer',
        SUBSYSTEM_OUTPUT = 'output',
        SUBSYSTEM_OPTIONS = 'options',
        SUBSYSTEM_STICKER = 'sticker',
        SUBSYSTEM_SUBSCRIPTION = 'subscription',
        SUBSYSTEM_MESSAGE = 'message';


    public static $defaults = [
        'password' => null,
    ];


    /** @var ConnectionInterface */
    private $connection = null;

    /** @var string */
    private $buffer = '';

    /** @var Deferred[] */
    private $queue = [];

    /** @var bool */
    private $idle = false;

    /** @var array */
    private $options;


    /**
     * Client constructor.
     * @param ConnectionInterface $connection
     * @param array $options
     */
    public function __construct(ConnectionInterface $connection, array $options = []) {
        $this->connection = $connection;
        $this->options = $options + static::$defaults;

        $this->connection->onReceive([$this, 'handleData']);

        if (!empty($this->options['password'])) {
            $this->sendCommand('password', $this->options['password']);

        }
    }


    /**
     * @param string $name
     * @param array $args
     * @return \Closure
     * @throws Exception
     */
    public function command($name, $args = null) {
        if (Commands::hasMethod($name) || $name === 'disconnect') {
            if (func_num_args() > 2 || !is_array($args)) {
                $args = array_slice(func_get_args(), 1);
            }

            return function() use ($name, $args) {
                return call_user_func_array([$this, $name], $args);
            };
        }

        throw new Exception("Unknown command: $name");

    }


    /**
     *
     */
    public function disconnect() {
        if ($this->connection) {
            $this->connection->send("close\n");
            $this->connection = null;

        }
    }


    /**
     * @return PromiseInterface
     */
    public function getCurrentSong() {
        return $this->sendCommand('currentsong')->then([Helpers::class, 'parseValues']);
    }

    /**
     * @return PromiseInterface
     */
    public function getStatus() {
        return $this->sendCommand('status')->then([Helpers::class, 'parseValues']);
    }

    /**
     * @return PromiseInterface
     */
    public function getStats() {
        return $this->sendCommand('stats')->then([Helpers::class, 'parseValues']);
    }



    /**
     * @return PromiseInterface
     */
    public function getReplayGainStatus() {
        return $this->sendCommand('replay_gain_status')->then([Helpers::class, 'parseValues']);
    }



    /**
     * @param string $uri
     * @param int $pos
     * @return PromiseInterface
     */
    public function addSong($uri, $pos = null) {
        $uri = Helpers::filterUri($uri);

        return $this->sendCommand('addid', $uri, $pos)
            ->then(function($data) {
                list(, $val) = Helpers::parseLine(reset($data));
                return $val;
            });
    }

    /**
     * @param string $tag
     * @param string $needle
     * @param bool $strict
     * @return PromiseInterface
     */
    public function findInPlaylist($tag, $needle, $strict = false) {
        return $this->sendCommand($strict ? 'playlistfind' : 'playlistsearch', $tag, $needle)->then([Helpers::class, 'parseEntries']);
    }

    /**
     * @param int $songId
     * @return PromiseInterface
     */
    public function getPlaylistSongInfo($songId = null) {
        return $this->sendCommand('playlistid', $songId)->then([Helpers::class, 'parseEntries']);
    }

    /**
     * @param int $pos
     * @param int|bool $end
     * @return PromiseInterface
     */
    public function getPlaylistInfo($pos = null, $end = null) {
        return $this->sendCommand('playlistinfo', Helpers::formatPosOrRange($pos, $end))->then([Helpers::class, 'parseEntries']);
    }


    /**
     * @param string $name
     * @param bool $meta
     * @return PromiseInterface
     */
    public function getPlaylist($name, $meta = true) {
        return $this->sendCommand($meta ? 'listplaylistinfo' : 'listplaylist', $name)->then([Helpers::class, 'parseEntries']);
    }

    /**
     * @return PromiseInterface
     */
    public function getPlaylists() {
        return $this->sendCommand('listplaylists')->then([Helpers::class, 'parseList']);
    }

    /**
     * @param string $type
     * @param array|null $criteria
     * @param null $group
     * @return PromiseInterface
     */
    public function listTags($type, array $criteria = null, $group = null) {
        $args = [$type];

        if (!empty($criteria)) {
            foreach ($criteria as $tag => $needle) {
                $args[] = $tag;
                $args[] = $needle;
            }
        }

        if ($group) {
            $group = (array) $group;

            foreach ($group as $grp) {
                $args[] = 'group';
                $args[] = $grp;
            }
        }

        return $this->sendCommand('list', $args)
            ->then(function($data) use ($type, $group) {
                if (empty($data)) {
                    return [];
                } else if (!$group) {
                    return Helpers::parseList($data);
                }

                $type = Helpers::normalizeKey($type);
                $group = array_map([Helpers::class, 'normalizeKey'], $group);
                $values = [];
                $info = null;

                for ($i = 0, $n = count($data); $i < $n; $i++) {
                    list ($key, $val) = Helpers::parseLine($data[$i]);

                    if ($key === $type) {
                        if ($info) {
                            $cursor = & $values;

                            foreach ($group as $k) {
                                $cursor = & $cursor[isset($info[$k]) ? $info[$k] : null];
                            }

                            $cursor[] = $info[$type];
                            $info = [];

                        }
                    }

                    $info[$key] = $val;

                }

                if ($info) {
                    $cursor = & $values;

                    foreach ($group as $k) {
                        $cursor = & $cursor[isset($info[$k]) ? $info[$k] : null];
                    }

                    $cursor[] = $info[$type];

                }

                unset($cursor);
                return $values;

            });
    }

    /**
     * @param string $uri
     * @param bool $meta
     * @return PromiseInterface
     */
    public function listAll($uri = null, $meta = false) {
        $uri = Helpers::filterUri($uri);

        return $this->sendCommand($meta ? 'listallinfo' : 'listall', $uri)
            ->then(function($data) use ($uri, $meta) {
                return Helpers::parseFiles($data, $uri, $meta);
            });
    }

    /**
     * @param string $uri
     * @return PromiseInterface
     */
    public function listFiles($uri = null) {
        $uri = Helpers::filterUri($uri);

        return $this->sendCommand('listfiles', $uri)
            ->then(function($data) use ($uri) {
                return Helpers::parseFiles($data, $uri);
            });
    }

    /**
     * @param string $uri
     * @return PromiseInterface
     */
    public function listInfo($uri = null) {
        $uri = Helpers::filterUri($uri);

        return $this->sendCommand('lsinfo', $uri)
            ->then(function($data) use ($uri) {
                return Helpers::parseFiles($data, $uri);
            });
    }


    /**
     * @return PromiseInterface
     */
    public function listMounts() {
        return $this->sendCommand('listmounts')->then(function($data) {
            return Helpers::parseEntries($data, 'mount');
        });
    }

    /**
     * @return PromiseInterface
     */
    public function listNeighbors() {
        return $this->sendCommand('listneighbors')->then(function($data) {
            return Helpers::parseEntries($data, 'neighbor');
        });
    }


    /**
     * @return PromiseInterface
     */
    public function getOutputs() {
        return $this->sendCommand('outputs')->then(function($data) {
            return Helpers::parseEntries($data, 'outputid');
        });
    }


    /**
     * @return PromiseInterface
     */
    public function getConfig() {
        return $this->sendCommand('config')->then([Helpers::class, 'parseValues']);
    }

    /**
     * @return PromiseInterface
     */
    public function getAvailableCommands() {
        return $this->sendCommand('commands')->then([Helpers::class, 'parseList']);
    }

    /**
     * @return PromiseInterface
     */
    public function getUnavailableCommands() {
        return $this->sendCommand('notcommands')->then([Helpers::class, 'parseList']);
    }

    /**
     * @return PromiseInterface
     */
    public function getTagTypes() {
        return $this->sendCommand('tagtypes')->then([Helpers::class, 'parseList']);
    }

    /**
     * @return PromiseInterface
     */
    public function getUrlHandlers() {
        return $this->sendCommand('urlhandlers')->then([Helpers::class, 'parseList']);
    }

    /**
     * @return PromiseInterface
     */
    public function getDecoders() {
        return $this->sendCommand('decoders')->then(function($data) {
            return Helpers::parseEntries($data, 'plugin');
        });
    }


    /**
     * @return PromiseInterface
     */
    public function getChannels() {
        return $this->sendCommand('channels')->then([Helpers::class, 'parseList']);
    }

    /**
     * @return PromiseInterface
     */
    public function readMessages() {
        return $this->sendCommand('readmessages')->then(function($data) {
            $messages = [];
            $channel = null;

            foreach ($data as $line) {
                list($key, $val) = Helpers::parseLine($line);

                if ($key === 'channel') {
                    $channel = $val;
                } else {
                    $messages[$channel][] = $val;
                }
            }

            return $messages;

        });
    }








    /**
     * @return Batch
     */
    public function batch() {
        return new Batch($this);
    }

    /**
     * @param Batch $batch
     * @return PromiseInterface
     */
    public function runBatch(Batch $batch) {
        $commands = $batch->getCommands();
        $commands = array_map(function($cmd) { return call_user_func_array([$this, 'formatCommand'], (array) $cmd); }, $commands);
        array_unshift($commands, 'command_list_begin');
        array_push($commands, 'command_list_end');

        return $this->connection->send(implode("\n", $commands) . "\n")->then([$this, 'expectResponse']);

    }


    /**
     * @param null $subsystems
     * @return mixed|PromiseInterface
     */
    public function idle($subsystems = null) {
        if ($subsystems === false) {
            $promise = $this->idle['promise'];
            $this->idle['promise'] = null;

            $this->connection->send("noidle\n");

            return $promise;

        } else if ($subsystems === true) {
            if (!isset($this->idle['subsystems'])) {
                $this->idle['subsystems'] = [];

            }

            return $this->idle['promise'] = $this->sendCommand('idle', $this->idle['subsystems'])->then([$this, 'handleIdle']);

        } else {
            $subsystems = $subsystems !== null ? (is_array($subsystems) ? $subsystems : func_get_args()) : [];

            $this->idle = [
                'subsystems' => $subsystems,
                'promise' => $this->sendCommand('idle', $subsystems)->then([$this, 'handleIdle']),
            ];

            return $this->idle['promise'];

        }
    }


    /** internal */





    /**
     * @param string $command
     * @param array|mixed $args
     * @return string
     */
    protected function formatCommand($command, $args = null) {
        $msg = [$command];

        if (func_num_args() > 1) {
            if (!is_array($args)) {
                $args = array_slice(func_get_args(), 1);

            }

            foreach ($args as $arg) {
                if ($arg !== null) {
                    $msg[] = is_string($arg) && preg_match('/\s/', $arg) ? '"' . $arg . '"' : $arg;

                }
            }
        }

        return implode(' ', $msg);

    }

    /**
     * @param string $command
     * @param array|mixed $args
     * @return PromiseInterface
     */
    protected function sendCommand($command, $args = null) {
        $msg = call_user_func_array([$this, 'formatCommand'], func_get_args());

        if (isset($this->idle['promise'])) {
            $promise = $this->idle(false)->then(function() use ($msg) {
                return $this->connection->send($msg . "\n");

            })->then([$this, 'expectResponse']);

            $promise->then(function() {
                return $this->idle(true);

            });

            return $promise;

        }

        return $this->connection->send($msg . "\n")->then([$this, 'expectResponse']);

    }

    /**
     * @param string $data
     */
    public function handleData($data) {
        while (preg_match('/^(ok|ack)(?:\s+(.+))?$/mi', $data, $matches, PREG_OFFSET_CAPTURE)) {
            $buf = trim($this->buffer . substr($data, 0, $matches[0][1]));
            $this->buffer = '';
            $data = substr($data, strlen($matches[0][0]) + $matches[0][1]);

            if (strtolower($matches[1][0]) === 'ack') {
                $this->handleError($matches[2][0]);

            } else {
                $this->handleResponse($buf);

            }
        }

        if ($data) {
            $this->buffer .= $data;

        }
    }

    /**
     * @param string $data
     */
    public function handleIdle($data) {
        $data = array_filter($data, function($line) {
            return strncmp($line, 'changed:', 8) === 0;
        });

        $data = array_map(function($line) {
            return trim(substr($line, 8));

        }, $data);

        foreach ($data as $subsystem) {
            $this->emit('update', [$subsystem]);

        }

        if (isset($this->idle['promise'])) {
            $this->idle['promise'] = null;
            $this->idle(true);

        }
    }

    /**
     * @param string $data
     */
    protected function handleResponse($data) {
        $data = empty($data) ? [] : explode("\n", $data);

        $this->emit('response', [$data]);

        if (!empty($this->queue)) {
            /** @var Deferred $handler */
            $handler = array_shift($this->queue);
            $handler->resolve($data);

        }
    }

    /**
     * @param string $info
     */
    protected function handleError($info) {
        if (preg_match('/^\[(\d+)@\d+\]\s+\{([^\}]+)\}\s+(.+)$/', $info, $m)) {
            $e = new Exception("{$m[2]}: {$m[3]}", (int) $m[1]);

        } else {
            $e = new Exception($info);

        }

        $this->emit('error', [$e]);

        if (!empty($this->queue)) {
            /** @var Deferred $handler */
            $handler = array_shift($this->queue);
            $handler->reject($e);

        }
    }

    /**
     * @return PromiseInterface
     */
    public function expectResponse() {
        $this->queue[] = $handler = new Deferred();
        return $handler->promise();

    }


    /**
     * @param string $name
     * @param array $arguments
     * @return PromiseInterface
     */
    public function __call($name, $arguments) {
        $cmd = call_user_func_array([Commands::class, $name], $arguments);
        return call_user_func_array([$this, 'sendCommand'], $cmd);

    }

    /**
     * @param string $name
     * @return callable
     * @throws Exception
     */
    public function __get($name) {
        if (Commands::hasMethod($name) || $name === 'disconnect') {
            return [$this, $name];
        }

        throw new Exception("Unknown command: $name");

    }


    /**
     *
     */
    public function __destruct() {
        $this->disconnect();

    }

}
