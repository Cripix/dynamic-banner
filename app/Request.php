<?php

    namespace Tivet\Banner;

    use Vectorface\Whip\Whip;

    class Request
    {
        /**
         * @return false|string
         */
        public static function getValidIpAddress()
        {
            $whip = new Whip();

            return $whip->getValidIpAddress();
        }
    }