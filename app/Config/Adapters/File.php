<?php

    namespace Tivet\Banner\Config\Adapters;

    class File
    {
        const CONFIG_DIR       = 'config';

        const CONFIG_EXTENSION = 'php';


        /**
         * @param string $fileName
         * @return array
         * @throws \Exception
         */
        public function getConfig(string $fileName) : array
        {
            $file = BASE_DIR . DIRECTORY_SEPARATOR . self::CONFIG_DIR . DIRECTORY_SEPARATOR . $fileName . '.' . self::CONFIG_EXTENSION;

            if (!file_exists($file)) {
                throw new \Exception('Config not exist');
            }

            return (include $file);
        }
    }