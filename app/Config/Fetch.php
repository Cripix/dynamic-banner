<?php

    namespace Tivet\Banner\Config;

    use Tivet\Banner\Config\Adapters\File;

    class Fetch
    {
        private $configName;

        private $configEngine;


        /**
         * Fetch constructor.
         * @param string $configName
         * @param string $configEngine
         */
        public function __construct(string $configName, $configEngine = File::class)
        {
            $this->configName = $configName;
            $this->configEngine = new $configEngine;
        }


        /**
         * @return mixed
         */
        public function getData()
        {
            return $this->configEngine->getConfig($this->configName);
        }
    }