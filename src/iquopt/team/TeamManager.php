<?php

namespace iquopt\team;

use iquopt\HCF;
use iquopt\team\commands\TeamCommand;
use iquopt\team\Team;
use iquopt\util\Config;

use pocketmine\utils\SingletonTrait;
use pocketmine\Server;

class TeamManager {
    use SingletonTrait;

    /** @var Team[] */
    private array $teams = [];

    private string $dataFolder;

    public function __construct(HCF $plugin) {
        self::setInstance($this);
        
        $this->dataFolder = $plugin->getDataFolder() . "data/teams/";
        @mkdir($this->dataFolder);
        $plugin->getServer()->getCommandMap()->register("team", new TeamCommand());
        $this->loadAll();
    }

    public function createTeam(string $name, string $leader): ?Team {
        if (isset($this->teams[strtolower($name)])) return null;

        $team = new Team($name, $leader);
        $this->teams[strtolower($name)] = $team;
        $this->saveTeam($team);
        return $team;
    }

    public function getTeam(string $name): ?Team {
        return $this->teams[strtolower($name)] ?? null;
    }

    public function getTeamByPlayer(string $player): ?Team {
        foreach ($this->teams as $team) {
            if ($team->isMember($player)) return $team;
        }
        return null;
    }

    public function disbandTeam(string $name): void {
        unset($this->teams[strtolower($name)]);
        @unlink($this->dataFolder . strtolower($name) . ".json");
    }

    public function saveTeam(Team $team): void {
        $file = $this->dataFolder . strtolower($team->getName()) . ".json";
        file_put_contents($file, json_encode($team->toArray(), JSON_PRETTY_PRINT));
    }

    public function loadAll(): void {
        $count = 0;
        foreach (glob($this->dataFolder . "*.json") as $file) {
            $data = json_decode(file_get_contents($file), true);
            if (is_array($data)) {
                $team = Team::fromArray($data);
                $this->teams[strtolower($team->getName())] = $team;
                $count++;
            }
        }

        Server::getInstance()->getLogger()->info(Config::$PREFIX . " §fLoaded " . Config::$SERVER_COLOR . "{$count} §fteams.");
    }

    public function saveAll(): void {
        foreach ($this->teams as $team) {
            $this->saveTeam($team);
        }
    }
}

