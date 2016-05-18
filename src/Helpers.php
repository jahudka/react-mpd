<?php
/**
 * Created by PhpStorm.
 * User: danik
 * Date: 16/05/16
 * Time: 21:04
 */

namespace Jahudka\MPD;


class Helpers {

    /**
     * @param array $data
     * @return array
     */
    public static function parseValues(array $data) {
        $values = [];

        foreach ($data as $line) {
            list($key, $val) = static::parseLine($line);

            if ($key !== null) {
                $values[$key] = $val;
            }
        }

        return $values;

    }

    /**
     * @param array $data
     * @param string $key
     * @return array
     */
    public static function parseList(array $data, $key = null) {
        $values = [];

        if (empty($data)) {
            return $values;
        }

        if (!$key) {
            list($key) = static::parseLine(reset($data));

            if (!$key) {
                return $data;
            }
        }

        foreach ($data as $line) {
            list($k, $v) = static::parseLine($line);

            if ($k === $key) {
                $values[] = $v;
            }
        }

        return $values;

    }

    /**
     * @param array $data
     * @param string $separator
     * @return array
     */
    public static function parseEntries(array $data, $separator = 'file') {
        $entries = [];
        $entry = null;

        foreach ($data as $line) {
            list ($key, $val) = static::parseLine($line);
            if ($key !== null) {
                if ($key === $separator) {
                    if ($entry) {
                        $entries[] = $entry;
                    }

                    $entry = [];

                }

                $entry[$key] = $val;

            }
        }

        if ($entry) {
            $entries[] = $entry;
        }

        return $entries;

    }

    public static function parseFiles(array $data, $baseUri = null, $meta = true) {
        $files = [];
        $last = null;

        if ($baseUri) {
            $baseUriLen = strlen($baseUri);
        }

        foreach ($data as $line) {
            list($key, $val) = static::parseLine($line);

            if ($key !== 'file' && $key !== 'directory') {
                if ($meta && isset($last)) {
                    $last[$key] = $val;
                }

                continue;

            } else if ($meta) {
                unset($last);
            }

            if ($baseUri) {
                if (strlen($val) > $baseUriLen && strncmp($val, $baseUri, $baseUriLen) === 0) {
                    $val = ltrim(substr($val, $baseUriLen), '/');
                } else {
                    continue;
                }
            }

            $path = explode('/', $val);
            $cursor = & $files;

            if ($key === 'file') {
                $file = array_pop($path);
            }

            foreach ($path as $dir) {
                $cursor = & $cursor[$dir];
            }

            if ($key === 'file') {
                if ($meta) {
                    $cursor[$file] = [];
                    $last = & $cursor[$file];

                } else {
                    $cursor[] = $file;
                }
            } else {
                $cursor = [];
            }

            unset($cursor);

        }

        unset($cursor, $last);
        return $files;

    }

    /**
     * @param string $line
     * @return array
     */
    public static function parseLine($line) {
        if (preg_match('/^([^:]+):\s*(.*?)\s*$/', $line, $matches)) {
            return [static::normalizeKey($matches[1]), static::parseValue($matches[2])];
        } else {
            return [null, static::parseValue($line)];
        }
    }

    /**
     * @param string $key
     * @return string
     */
    public static function normalizeKey($key) {
        return preg_replace_callback('/[-_](.)/', function($m) {
            return strtoupper($m[1]);

        }, lcfirst($key));
    }

    /**
     * @param string $value
     * @return float|int|bool|string|null
     */
    public static function parseValue($value) {
        if (preg_match('/^(?:\d+|\d*\.\d+)$/', $value)) {
            return strpos($value, '.') === false ? (int) $value : (float) $value;

        } else if (preg_match('/^(?:true|false|null)$/i', $value)) {
            return json_decode(strtolower($value));

        } else {
            return $value;

        }
    }

    /**
     * @param mixed $value
     * @param string $type
     * @return float|int|string|mixed
     */
    public static function formatArg($value, $type) {
        switch ($type) {
            case 'uri':
                return static::filterUri($value);

            case 'string':
                return (string) $value;

            case 'int':
                return (int) $value;

            case 'float':
                return (float) $value;

            case 'bool':
                return static::boolToInt($value);

            default:
                return $value;
        }
    }

    /**
     * @param string $uri
     * @return string
     */
    public static function filterUri($uri) {
        return $uri === null ? $uri : rtrim($uri, '/');
    }

    /**
     * @param bool $v
     * @return int
     */
    public static function boolToInt($v) {
        return $v ? 1 : 0;
    }

    /**
     * @param int|null $start
     * @param int|bool $end
     * @param bool $force
     * @return string
     */
    public static function formatRange($start, $end, $force = false) {
        return $force || $start !== null ? $start . ':' . ($end === true ? '' : $end) : null;
    }

    /**
     * @param int|null $start
     * @param int|bool|null $end
     * @return string
     */
    public static function formatPosOrRange($start, $end) {
        return $end === null ? $start : static::formatRange($start, $end);
    }
}
