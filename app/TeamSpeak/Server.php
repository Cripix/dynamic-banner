<?php

    namespace Tivet\Banner\TeamSpeak;

    class Server
    {
        private static $serverData     = [];

        private static $adminClients   = [];

        private static $supportClients = [];


        public function __construct()
        {
            $factory = Factory::getFactory();

            if (empty(static::$serverData)) {
                static::$serverData = $factory->getInfo(true, true);
            }

            if (empty(static::$adminClients)) {
                static::$adminClients = $factory->clientList([
                    'client_type'         => 0,
                    'client_servergroups' => conf('banner.admin_server_group_id'),
                ]);
            }

            if (empty(static::$supportClients)) {
                static::$supportClients = $factory->clientList([
                    'client_type'         => 0,
                    'client_servergroups' => conf('banner.support_server_group_id'),
                ]);
            }
        }


        public static function getServerOnlineClientCount($onlyVoice = false)
        {
            if ($onlyVoice) {
                return static::$serverData['virtualserver_clientsonline'] > 0
                    ? (static::$serverData['virtualserver_clientsonline'] - static::$serverData['virtualserver_queryclientsonline'])
                    : static::$serverData['virtualserver_clientsonline'];
            }

            return static::$serverData['virtualserver_clientsonline'];
        }


        public static function getServerMaxClientLimit()
        {
            return static::$serverData['virtualserver_maxclients'];
        }


        public static function getServerCurrentActiveChannelCount()
        {
            return static::$serverData['virtualserver_channelsonline'];
        }


        public static function getServerTotalPing()
        {
            return round(static::$serverData['virtualserver_total_ping']->toString());
        }


        public static function getServerTotalPacketLoss()
        {
            return (int) static::$serverData['virtualserver_total_packetloss_total'] * 100;
        }


        public static function getServerVersion()
        {
            $parse = explode(' ', static::$serverData['virtualserver_version']->toString(), 2);

            return $parse[0];
        }


        public static function getServerPlatform()
        {
            return static::$serverData['virtualserver_platform']->toString();
        }


        public static function getOnlineAdminCount()
        {
            return count(static::$adminClients);
        }


        public static function getOnlineSupportCount()
        {
            return count(static::$supportClients);
        }
    }