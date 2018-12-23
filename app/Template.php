<?php

    namespace Tivet\Banner;

    use Dflydev\DotAccessData\Data;

    class Template
    {
        private static $templateName;

        /**
         * @var Data
         */
        private static $templateConfig;

        const BACKGROUND = 'background.png';

        const CONFIG     = 'config.php';


        public function __construct(string $templateName)
        {
            if (!static::$templateName) {
                static::$templateName = $templateName;
            }

            if (!static::$templateConfig) {
                static::$templateConfig = new Data((include BASE_DIR . "/resources/template/{$templateName}/" . self::CONFIG));
            }
        }


        /**
         * @return string
         */
        public function getBackgroundLocation()
        {
            return BASE_DIR . "/resources/template/" . static::$templateName . "/" . self::BACKGROUND;
        }


        /**
         * @param string $notation
         * @return array|mixed|null
         */
        public function getConfig(string $notation = null)
        {
            if ($notation === null) {
                return static::$templateConfig->export();
            }

            return static::$templateConfig->get($notation);
        }
    }