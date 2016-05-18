<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 17/05/16
 * Time: 18:22
 */

namespace Jahudka\MPD;

/**
 * @method static array clearLastError() : clearerror
 * @method static array getCurrentSong() : currentsong
 * @method static array getStatus() : status
 * @method static array getStats() : stats
 * @method static array toggleConsume(bool $state = true) : consume
 * @method static array setCrossfadeLength(float $length) : crossfade
 * @method static array setMixRampDb(float $db) : mixrampdb
 * @method static array setMixRampDelay(float $delay) : mixrampdelay
 * @method static array toggleRandom(bool $state = true) : random
 * @method static array toggleRepeat(bool $state = true) : repeat
 * @method static array toggleSingle(bool $state = true) : single
 * @method static array setReplayGainMode(string $mode) : replay_gain_mode
 * @method static array getReplayGainStatus() : replay_gain_status
 * @method static array next() : next
 * @method static array togglePause(bool $state = true) : pause
 * @method static array play(int $pos = null) : play
 * @method static array playSong(int $id) : playid
 * @method static array seekSong(int $id, float $time = 0) : seekid
 * @method static array stop() : stop
 * @method static array previous() : previous
 * @method static array add(string $uri) : add
 * @method static array addSong(string $uri, int $pos = null) : addid
 * @method static array clear() : clear
 * @method static array removeSong(int $id) : deleteid
 * @method static array moveSong(int $id, int $to) : moveid
 * @method static array getPlaylistSongInfo(int $id = null) : playlistid
 * @method static array swap(int $a, int $b) : swap
 * @method static array swapSongs(int $a, int $b) : swapid
 * @method static array addSongTag(int $id, string $tag, string $value) : addtagid
 * @method static array clearSongTag(int $id, string $tag) : cleartagid
 * @method static array clearSongTags(int $id) : cleartagid
 * @method static array getPlaylists() : listplaylists
 * @method static array addToPlaylist(string $name, string $uri) : playlistadd
 * @method static array clearPlaylist(string $name) : playlistclear
 * @method static array removeFromPlaylist(string $name, int $pos) : playlistdelete
 * @method static array moveInPlaylist(string $name, int $from, int $to) : playlistmove
 * @method static array renamePlaylist(string $name, string $newName) : rename
 * @method static array removePlaylist(string $name) : rm
 * @method static array savePlaylist(string $name) : save
 * @method static array listFiles(string $uri = null) : listfiles
 * @method static array listInfo(string $uri = null) : lsinfo
 * @method static array readComments(string $uri = null) : readcomments
 * @method static array mount(string $path, string $uri) : mount
 * @method static array unmount(string $path) : unmount
 * @method static array listMounts() : listmounts
 * @method static array listNeighbors() : listneighbors
 * @method static array getSticker(string $type, string $uri, string $name) : sticker get
 * @method static array setSticker(string $type, string $uri, string $name, string $value) : sticker set
 * @method static array removeSticker(string $type, string $uri, string $name = null) : sticker delete
 * @method static array listStickers(string $type, string $uri) : sticker list
 * @method static array ping() : ping
 * @method static array disableOutput(int $id) : disableoutput
 * @method static array enableOutput(int $id) : enableoutput
 * @method static array toggleOutput(int $id) : toggleoutput
 * @method static array getOutputs() : outputs
 * @method static array getConfig() : config
 * @method static array getAvailableCommands() : commands
 * @method static array getUnavailableCommands() : notcommands
 * @method static array getTagTypes() : tagtypes
 * @method static array getUrlHandlers() : urlhandlers
 * @method static array getDecoders() : decoders
 * @method static array subscribeToChannel(string $name) : subscribe
 * @method static array unsubscribeFromChannel(string $name) : unsubscribe
 * @method static array getChannels() : channels
 * @method static array sendMessage(string $channel, string $message) : sendmessage
 * @method static array readMessages() : readmessages
 */
class Commands {

    /** @var array */
    private static $meta = null;



    /**
     * @param int $volume
     * @return array
     */
    public static function setVolume($volume) {
        return ['setvol', max(0, min(100, $volume))];
    }

    /**
     * @param int $song
     * @param float $time
     * @return array
     */
    public static function seek($song = null, $time = null) {
        if ($song === null) {
            $cmd = 'seekcur';
            $args = [0];

        } else if ($time === null) {
            $cmd = 'seekcur';
            $args = [$song];

        } else {
            $cmd = 'seek';
            $args = [$song, $time];

        }

        return [$cmd, $args];

    }




    /**
     * @param int $pos
     * @param int|bool $end
     * @return array
     */
    public static function remove($pos, $end = null) {
        return ['delete', Helpers::formatPosOrRange($pos, $end)];
    }

    /**
     * @param int $pos
     * @param int|bool $end
     * @param int $to
     * @return array
     */
    public static function move($pos, $end = null, $to = null) {
        if ($to === null) {
            $to = $end;
            $end = null;
        }

        return ['move', Helpers::formatPosOrRange($pos, $end), $to];
    }






    /**
     * @param string $tag
     * @param string $needle
     * @param bool $strict
     * @return array
     */
    public static function findInPlaylist($tag, $needle, $strict = false) {
        return [$strict ? 'playlistfind' : 'playlistsearch', $tag, $needle];
    }

    /**
     * @param int $pos
     * @param int $end
     * @return array
     */
    public static function getPlaylistInfo($pos = null, $end = null) {
        return ['playlistinfo', Helpers::formatPosOrRange($pos, $end)];
    }

    /**
     * @param int $version
     * @param int $start
     * @param int|bool $end
     * @return array
     */
    public static function getPlaylistChanges($version, $start = null, $end = true) {
        if (is_bool($version)) {
            @list($brief, $version, $start, $end) = func_get_args();
        } else {
            $brief = false;
        }

        return [$brief ? 'plchangesposid' : 'plchanges', $version, Helpers::formatRange($start, $end)];
    }

    /**
     * @param int $priority
     * @param int $start
     * @param int|bool $end
     * @return array
     */
    public static function setPriority($priority, $start, $end = true) {
        return ['prio', max(0, min(255, $priority)), Helpers::formatRange($start, $end)];
    }

    /**
     * @param int $priority
     * @param int $id
     * @return array
     */
    public static function setSongPriority($priority, $id) {
        return ['prioid', max(0, min(255, $priority)), $id];
    }

    /**
     * @param int $id
     * @param float $start
     * @param float|bool $end
     * @return array
     */
    public static function setSongRange($id, $start = null, $end = null) {
        return ['rangeid', $id, Helpers::formatRange($start, $end, true)];
    }

    /**
     * @param int $start
     * @param int $end
     * @return array
     */
    public static function shuffle($start = null, $end = null) {
        return ['shuffle', Helpers::formatRange($start, $end)];
    }

    /**
     * @param string $name
     * @param bool $meta
     * @return array
     */
    public static function getPlaylist($name, $meta = true) {
        return [$meta ? 'listplaylistinfo' : 'listplaylist', $name];
    }

    /**
     * @param string $name
     * @param int $start
     * @param int|bool $end
     * @return array
     */
    public static function loadPlaylist($name, $start = null, $end = null) {
        return ['load', $name, Helpers::formatRange($start, $end)];
    }





    /**
     * @param array $criteria
     * @param string $group
     * @return array
     */
    public static function count(array $criteria, $group = null) {
        $args = [];

        foreach ($criteria as $tag => $needle) {
            $args[] = $tag;
            $args[] = $needle;
        }

        if ($group) {
            $args[] = 'group';
            $args[] = $group;
        }

        return ['count', $args];
    }

    /**
     * @param array $criteria
     * @param bool $cs
     * @param int $start
     * @param int|bool $end
     * @return array
     */
    public static function find(array $criteria, $cs = false, $start = null, $end = null) {
        $cmd = $cs ? 'find' : 'search';
        $window = Helpers::formatRange($start, $end);
        $args = [];

        foreach ($criteria as $type => $query) {
            $args[] = $type;
            $args[] = $query;
        }

        if ($window) {
            $args[] = 'window';
            $args[] = $window;
        }

        return [$cmd, $args];
    }

    /**
     * @param array $criteria
     * @param bool $cs
     * @return array
     */
    public static function findAndAdd(array $criteria, $cs = false) {
        $cmd = $cs ? 'findadd' : 'searchadd';
        $args = [];

        foreach ($criteria as $type => $query) {
            $args[] = $type;
            $args[] = $query;
        }

        return [$cmd, $args];
    }

    /**
     * @param string $name
     * @param array $criteria
     * @return array
     */
    public static function searchIntoPlaylist($name, array $criteria) {
        $args = [$name];

        foreach ($criteria as $type => $query) {
            $args[] = $type;
            $args[] = $query;
        }

        return ['searchaddpl', $args];
    }

    /**
     * @param string $type
     * @param array $criteria
     * @param array|string $group
     * @return array
     */
    public static function listTags($type, array $criteria = null, $group = null) {
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

        return ['list', $args];

    }

    /**
     * @param string $uri
     * @param bool $meta
     * @return array
     */
    public static function listAll($uri = null, $meta = false) {
        $uri = Helpers::filterUri($uri);
        return [$meta ? 'listallinfo' : 'listall', $uri];
    }




    /**
     * @param string $uri
     * @param bool $force
     * @return array
     */
    public static function update($uri = null, $force = false) {
        if (is_bool($uri)) {
            $force = $uri;
            $uri = null;
        }

        $uri = Helpers::filterUri($uri);
        return [$force ? 'rescan' : 'update', $uri];
    }




    /**
     * @param string $type
     * @param string $uri
     * @param string $name
     * @param string $value
     * @param string $op
     * @return array
     */
    public static function findStickers($type, $uri, $name, $value = null, $op = '=') {
        return ['sticker', 'find', $type, $uri, $name, $value === null ? null : $op, $value];
    }







    /**
     * @param string $name
     * @param array $arguments
     * @return array
     * @throws Exception
     */
    public static function __callStatic($name, $arguments) {
        $meta = static::getMeta($name);

        if ($meta === false) {
            throw new Exception("Unknown command: $name");
        }

        $cmd = [$meta['command']];

        foreach ($meta['args'] as $i => $arg) {
            if (isset($arguments[$i])) {
                $cmd[] = Helpers::formatArg($arguments[$i], $arg['type']);
            } else if (array_key_exists('default', $arg)) {
                if ($arg['default'] !== null) {
                    $cmd[] = Helpers::formatArg($arg['default'], $arg['type']);
                }
            } else {
                throw new \RuntimeException("Missing argument {$arg['name']} for method {$name}");
            }
        }

        return $cmd;

    }

    /**
     * @param string $name
     * @return bool
     */
    public static function hasMethod($name) {
        return (bool) static::getMeta($name);
    }

    /**
     * @param string $method
     * @return array
     * @throws Exception
     */
    protected static function getMeta($method) {
        if (self::$meta === null) {
            self::$meta = [];

            $ref = new \ReflectionClass(static::class);
            self::$meta += static::parseDocComment($ref->getDocComment());

            while ($ref->getName() !== self::class) {
                $ref = $ref->getParentClass();
                self::$meta += static::parseDocComment($ref->getDocComment());

            }
        }

        if (!isset(self::$meta[$method])) {
            return false;
        }

        return self::$meta[$method];

    }

    /**
     * @param string $comment
     * @return array
     */
    protected static function parseDocComment($comment) {
        $methods = [];

        if (preg_match_all('/@method\s+static\s+array\s+([^\s\(]+)\s*\(([^\)]*)\)\s*:\s*(\S+(?:[ ]+\S+)*)/m', $comment, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $args = [];

                if (!empty($match[2]) && preg_match_all('/(?<=^|,)\s*(?:(\S+)\s+)?\$(\S+?)(?:\s*=\s*(\S+))?\s*(?=,|$)/', $match[2], $m, PREG_SET_ORDER)) {
                    foreach ($m as $a) {
                        $arg = [
                            'type' => $a[2] === 'uri' ? 'uri' : $a[1],
                            'name' => $a[2],
                        ];

                        if (isset($a[3])) {
                            $arg['default'] = json_decode($a[3]);
                        }

                        $args[] = $arg;

                    }
                }

                $methods[$match[1]] = [
                    'command' => $match[3],
                    'args' => $args,
                ];
            }
        }

        return $methods;

    }
}
