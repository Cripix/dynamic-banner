<?php

    namespace Tivet\Banner;

    use Psr\SimpleCache\InvalidArgumentException;
    use Symfony\Component\Cache\Simple\FilesystemCache;

    class Cache
    {
        /**
         * @var FilesystemCache
         */
        private static $cache;


        /**
         * @param $key
         * @param $value
         * @param null $ttl
         * @return bool
         */
        public static function set($key, $value, $ttl = null)
        {
            try {
                return static::fileSystemCache()->set($key, $value, $ttl);
            }
            catch (InvalidArgumentException $e) {
                echo "[CACHE] {$e->getMessage()}";
            }
        }


        /**
         * @param $key
         * @param null $default
         * @return mixed|null
         */
        public static function get($key, $default = null)
        {
            try {
                return static::fileSystemCache()->get($key, $default);
            }
            catch (InvalidArgumentException $e) {
                echo "[CACHE] {$e->getMessage()}";
            }
        }


        /**
         * @param $key
         * @return bool
         */
        public static function has($key)
        {
            return static::fileSystemCache()->has($key);
        }


        private static function fileSystemCache()
        {
            if (!static::$cache) {
                static::$cache = new FilesystemCache('', conf('banner.cache_ttl'), BASE_DIR . '/cache');
            }

            return static::$cache;
        }
    }