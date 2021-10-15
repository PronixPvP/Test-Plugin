<?php

namespace DRAGKILLS;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    public \SQLite3 $sqlite;

    public function onEnable()
    {
        @mkdir($this->getDataFolder()); //use this cuz i dont implement plugin_data in lienepvp
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->sqlite = new \SQLite3($this->getDataFolder() . "data.db");
    }

    public function onJoin(PlayerJoinEvent $event){
        $this->sqlite->exec("CREATE TABLE IF NOT EXISTS players(id INTEGER PRIMARY KEY, name TEXT)");
        $this->sqlite->exec("INSERT INTO players(name) VALUES('{$event->getPlayer()->getName()}')");
        $res = $this->sqlite->query('SELECT * FROM players');
        $event->getPlayer()->sendMessage("Your Name = {$res->fetchArray()["name"]}");
    }
}
