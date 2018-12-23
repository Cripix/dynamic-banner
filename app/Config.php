<?php

    namespace Tivet\Banner;

    use Dflydev\DotAccessData\Data;
    use Tivet\Banner\Config\Adapters\File;
    use Tivet\Banner\Config\Fetch;

    class Config
    {
        private $configName;

        /**
         * @var Data
         */
        private static $configData = [];


        /**
         * Config constructor.
         * @param string $configName
         * @param string $configEngine
         */
        public function __construct(string $configName, $configEngine = File::class)
        {
            $this->configName = $configName;

            if (empty(static::$configData)) {
                static::$configData = new Data();
            }

            if (!static::$configData->has($configName)) {
                static::$configData->import([$configName => (new Fetch($configName, $configEngine))->getData()]);
            }
        }


        /**
         * @param string $config
         * @return array|mixed|null
         */
        public function get(string $config)
        {
            return static::$configData->get("{$this->configName}.$config");
        }
    }