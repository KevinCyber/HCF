<?php

namespace iquopt\util;

use iquopt\HCF;
use pocketmine\utils\TextFormat;

class Config {

    public static string $PREFIX = TextFormat::GRAY . "[" . TextFormat::RED . "HCF" . TextFormat::GRAY . "]";
    public static string $SERVER_COLOR = TextFormat::GREEN;

    /**
     * Loads config values on plugin initialization.
     */
    public function __construct(HCF $plugin) {
        $config = $plugin->getConfig();

        self::$PREFIX = TextFormat::colorize($config->get("PREFIX"));
        self::$SERVER_COLOR = TextFormat::colorize($config->get("SERVER_COLOR"));
    }

    /**
     * Placeholder for saving config, not used for reload.
     */
    public static function load(): void {
        HCF::getInstance()->getConfig()->save();
    }

    /**
     * Reloads the configuration values from config.yml.
     * Call this after updating the config file externally.
     */
    public static function reload(): void {
        $plugin = HCF::getInstance();
        $config = $plugin->getConfig();
        
        $config->reload();

        self::$PREFIX = TextFormat::colorize($config->get("PREFIX", self::$PREFIX));
        self::$SERVER_COLOR = TextFormat::colorize($config->get("SERVER_COLOR", self::$SERVER_COLOR));
    }
}
