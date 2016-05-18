<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 16/05/16
 * Time: 19:03
 */

namespace Jahudka\MPD;


use React\Promise\PromiseInterface;



/**
 * @method Batch clearLastError()
 * @method Batch getCurrentSong()
 * @method Batch getStatus()
 * @method Batch getStats()
 * @method Batch toggleConsume(bool $state = true)
 * @method Batch setCrossfadeLength(float $length)
 * @method Batch setMixRampDb(float $db)
 * @method Batch setMixRampDelay(float $delay)
 * @method Batch toggleRandom(bool $state = true)
 * @method Batch toggleRepeat(bool $state = true)
 * @method Batch setVolume(int $volume)
 * @method Batch toggleSingle(bool $state = true)
 * @method Batch setReplayGainMode(string $mode)
 * @method Batch getReplayGainStatus()
 * @method Batch next()
 * @method Batch togglePause(bool $state = true)
 * @method Batch play(int $pos = null)
 * @method Batch playSong(int $id)
 * @method Batch seekSong(int $id, float $time = 0)
 * @method Batch stop()
 * @method Batch previous()
 * @method Batch seek(int $song, float $time)
 * @method Batch add(string $uri)
 * @method Batch addSong(string $uri, int $pos = null)
 * @method Batch clear()
 * @method Batch remove(int $pos, int|bool $end = null)
 * @method Batch removeSong(int $id)
 * @method Batch move(int $pos, int|bool $end, int $to)
 * @method Batch moveSong(int $id, int $to)
 * @method Batch findInPlaylist(string $tag, string $needle, bool $strict = false)
 * @method Batch getPlaylistSongInfo(int $id = null)
 * @method Batch getPlaylistInfo(int $pos = null, int|bool $end = null)
 * @method Batch getPlaylistChanges(int $version, int $start = null, int|bool $end = true)
 * @method Batch setPriority(int $priority, int $start, int|bool $end = true)
 * @method Batch setSongPriority(int $priority, int $id)
 * @method Batch setSongRange(int $id, float $start = null, float|bool $end = null)
 * @method Batch shuffle(int $start = null, int|bool $end = null)
 * @method Batch swap(int $a, int $b)
 * @method Batch swapSongs(int $a, int $b)
 * @method Batch addSongTag(int $id, string $tag, string $value)
 * @method Batch clearSongTag(int $id, string $tag)
 * @method Batch clearSongTags(int $id)
 * @method Batch getPlaylist(string $name, bool $meta = true)
 * @method Batch loadPlaylist(string $name, int $start = null, int|bool $end = null)
 * @method Batch getPlaylists()
 * @method Batch addToPlaylist(string $name, string $uri)
 * @method Batch clearPlaylist(string $name)
 * @method Batch removeFromPlaylist(string $name, int $pos)
 * @method Batch moveInPlaylist(string $name, int $from, int $to)
 * @method Batch renamePlaylist(string $name, string $newName)
 * @method Batch removePlaylist(string $name)
 * @method Batch savePlaylist(string $name)
 * @method Batch count(array $criteria, string $group = null)
 * @method Batch find(array $criteria, bool $cs = false, int $start = null, int|bool $end = null)
 * @method Batch findAndAdd(array $criteria, bool $cs = false)
 * @method Batch searchIntoPlaylist(string $name, array $criteria)
 * @method Batch listTags(string $type, array $criteria = null, array|string $group = null)
 * @method Batch listAll(string $uri = null, bool $meta = false)
 * @method Batch listFiles(string $uri = null)
 * @method Batch listInfo(string $uri = null)
 * @method Batch readComments(string $uri = null)
 * @method Batch update(string $uri = null, bool $force = false)
 * @method Batch mount(string $path, string $uri)
 * @method Batch unmount(string $path)
 * @method Batch listMounts()
 * @method Batch listNeighbors()
 * @method Batch getSticker(string $type, string $uri, string $name)
 * @method Batch setSticker(string $type, string $uri, string $name, string $value)
 * @method Batch removeSticker(string $type, string $uri, string $name = null)
 * @method Batch listStickers(string $type, string $uri)
 * @method Batch findStickers(string $type, string $uri, string $name, string $value = null, string $op = "=")
 * @method Batch ping()
 * @method Batch disableOutput(int $id)
 * @method Batch enableOutput(int $id)
 * @method Batch toggleOutput(int $id)
 * @method Batch getOutputs()
 * @method Batch getConfig()
 * @method Batch getAvailableCommands()
 * @method Batch getUnavailableCommands()
 * @method Batch getTagTypes()
 * @method Batch getUrlHandlers()
 * @method Batch getDecoders()
 * @method Batch subscribeToChannel(string $name)
 * @method Batch unsubscribeFromChannel(string $name)
 * @method Batch getChannels()
 * @method Batch sendMessage(string $channel, string $message)
 * @method Batch readMessages()
 */
class Batch {

    /** @var Client */
    private $client;

    /** @var array */
    private $commands = [];


    /**
     * Batch constructor.
     * @param Client $client
     */
    public function __construct(Client $client = null) {
        $this->client = $client;
    }



    public function __call($name, $arguments) {
        $this->commands[] = call_user_func_array([Commands::class, $name], $arguments);
        return $this;
    }



    /**
     * @return PromiseInterface
     */
    public function run() {
        if (!isset($this->client)) {
            throw new \LogicException("No MPD client specified");
        }

        return $this->client->runBatch($this);

    }

    /**
     * @return array
     */
    public function getCommands() {
        return $this->commands;
    }
}
