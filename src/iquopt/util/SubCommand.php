<?php

namespace iquopt\util;

use pocketmine\command\CommandSender;

abstract class SubCommand {

    /** @var string The main name of the subcommand */
    protected string $name;

    /** @var string Description of the subcommand */
    protected string $description;

    /** @var string[] Aliases that can also trigger this subcommand */
    protected array $aliases;

    /**
     * SubCommand constructor.
     *
     * @param string $name The main subcommand name
     * @param string $description Description of what the subcommand does
     * @param string[] $aliases Alternative names (aliases) to invoke the subcommand
     */
    public function __construct(string $name, string $description = "", array $aliases = []) {
        $this->name = $name;
        $this->description = $description;
        $this->aliases = $aliases;
    }

    /**
     * Returns the main name of the subcommand.
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Returns the description of the subcommand.
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * Returns an array of aliases for the subcommand.
     *
     * @return string[]
     */
    public function getAliases(): array {
        return $this->aliases;
    }

    /**
     * Executes the subcommand.
     *
     * @param CommandSender $sender The sender executing the command
     * @param string[] $args Arguments passed after the subcommand name
     * @return void
     */
    abstract public function execute(CommandSender $sender, array $args): void;
}
