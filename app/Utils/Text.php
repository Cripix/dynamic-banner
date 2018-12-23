<?php

    namespace Tivet\Banner\Utils;

    class Text
    {
        /**
         * @param string $hex
         * @return array
         */
        public static function hex2rgb(string $hex)
        {
            $hex = str_replace("#", "", $hex);

            if (strlen($hex) == 3) {
                $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
            } else {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
            }
            $rgb = array($r, $g, $b);

            return $rgb;
        }


        /**
         * @param string $text
         * @return string|string[]|null
         */
        public static function properText(string $text)
        {
            $text = mb_convert_encoding($text, "HTML-ENTITIES", "UTF-8");
            $text = preg_replace('~^(&([a-zA-Z0-9]);)~', htmlentities('${1}'), $text);

            return ($text);
        }
    }