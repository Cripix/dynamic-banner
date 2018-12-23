<?php

    use Dflydev\DotAccessData\Data;
    use Tivet\Banner\Config;

    if (!function_exists('lang')) {
        function lang(string $notation)
        {
            $config = new Config('banner');
            $parse = explode('.', $notation, 2);
            $file = $parse[0];

            $lang = new Data(include BASE_DIR . "/resources/lang/{$config->get('language')}/{$file}.php");

            return $lang->get($parse[1]);
        }
    }

    if (!function_exists('conf')) {
        function conf(string $notation)
        {
            $parse = explode('.', $notation, 2);
            $file = $parse[0];

            $config = new Config($file);

            return $config->get($parse[1]);
        }
    }
