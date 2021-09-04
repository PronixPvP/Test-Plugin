<?php

namespace DRAGKILLS;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

    public \SQLite3 $sqlite;

    public function onEnable()
    {
        @mkdir($this->getDataFolder());
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->sqlite = new \SQLite3($this->getDataFolder() . "data.db");
    }

    public function onJoin(PlayerJoinEvent $event){
        $this->sqlite->exec("CREATE TABLE IF NOT EXISTS played(id INTEGER PRIMARY KEY, name TEXT)");
        $this->sqlite->exec("INSERT INTO played(name) VALUES('{$event->getPlayer()->getName()}')");
        $res = $this->sqlite->query('SELECT * FROM played');
        $event->getPlayer()->sendMessage("Your Name = {$res->fetchArray()["name"]}");
    }
}
