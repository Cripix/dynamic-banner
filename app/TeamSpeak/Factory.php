<?php

    namespace Tivet\Banner\TeamSpeak;

    use TeamSpeak3;

    class Factory
    {
        /**
         * @var \TeamSpeak3_Node_Server
         */
        private static $factory;


        /**
         * @return \TeamSpeak3_Node_Server
         */
        public static function getFactory()
        {
            if (!static::$factory) {

                $host = conf('teamspeak.host');
                $queryUsername = conf('teamspeak.query_username');
                $queryPassword = conf('teamspeak.query_password');
                $queryPort = conf('teamspeak.query_port');
                $serverPort = conf('teamspeak.server_port');
                $nickname = conf('teamspeak.nickname');

                static::$factory = TeamSpeak3::factory("serverquery://{$queryUsername}:{$queryPassword}@{$host}:{$queryPort}/?server_port={$serverPort}&blocking=0&nickname=" . urlencode($nickname));
            }

            return static::$factory;
        }


        /**
         * @return Client
         */
        public static function client()
        {
            try {
                return new Client();
            }
            catch (\Exception $e) {
                throw new \Exception("[TEAMSPEAK] {$e->getMessage()}");
            }
        }


        /**
         * @return Server
         */
        public static function server()
        {
            try {
                return new Server();
            }
            catch (\Exception $e) {
                throw new \Exception("[TEAMSPEAK] {$e->getMessage()}");
            }
        }
    }