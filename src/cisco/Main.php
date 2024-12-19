<?php

namespace cisco;

use pocketmine\command\Command;
use pocketmine\command\SimpleCommandMap;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

final class Main extends PluginBase {

    protected function onLoad(): void    {
        $server = $this->getServer();

        $newMap = new class extends SimpleCommandMap  {

            public function __construct(

            ) {
                parent::__construct(Server::getInstance());
            }

            /**
             * TODO: why pmmp does not do this?
             */
            public function getCommand(string $name): ?Command            {
                return $this->knownCommands[strtolower($name)] ?? null;
            }
        };

        $ref = new \ReflectionClass($server);
        $prop = $ref->getProperty('commandMap');
        $prop->setAccessible(true);
        $prop->setValue($server, $newMap);
        $prop->setAccessible(false);
    }
}