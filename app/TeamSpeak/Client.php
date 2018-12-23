<?php
    /**
     * Created by PhpStorm.
     * User: Can
     * Date: 23.12.2018
     * Time: 04:54
     */

    namespace Tivet\Banner\TeamSpeak;

    use Tivet\Banner\Request;

    class Client
    {
        private static $clientData = [];


        public function __construct()
        {
            $factory = Factory::getFactory();

            if (empty(static::$clientData)) {
                $clients = $factory->clientList([
                    'client_type'          => 0,
                    'connection_client_ip' => Request::getValidIpAddress(),
                ]);

                if (empty($clients)) {
                    throw new \Exception('Join the server.');
                }

                /** @var \TeamSpeak3_Node_Client $client */
                foreach ($clients as $client) {
                }

                static::$clientData = $client->getInfo(true, true);
            }
        }


        public static function getClientNickname()
        {
            return static::$clientData['client_nickname'];
        }


        public static function getClientVersion()
        {
            $parse = explode(' ', static::$clientData['client_version']->toString(), 2);

            return $parse[0];
        }
    }