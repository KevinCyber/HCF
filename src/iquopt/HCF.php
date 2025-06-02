<?php

namespace iquopt;

use iquopt\commands\CommandManager;
use iquopt\team\TeamManager;
use iquopt\util\Config;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat as TE;

class HCF extends PluginBase {
    use SingletonTrait;
    private Config $configurator;
    
    private CommandManager $commandManager;
    private TeamManager $teamManager;

    public function onEnable(): void {
        $this->configurator = new Config($this);

        $this->commandManager = new CommandManager($this);
        $this->teamManager = new TeamManager($this);    

        Config::load();
        $this->getLogger()->info(TE::colorize("&a HCF ENABLED"));
    }

    public function onDisable(): void {
        $this->getLogger()->info(TE::colorize("&c HCF DISABLED"));
    }
}
