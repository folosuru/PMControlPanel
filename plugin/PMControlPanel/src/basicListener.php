<?php

namespace folosuru\PMControlPanel;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class basicListener implements Listener{

    private PMControlPanel $plugin;

    public function __construct(){
        $this->plugin = PMControlPanel::getInstance();
    }

    public function onJoin(PlayerJoinEvent $event){
        $this->plugin->addLog(
            "player-join",
            [],
            $event->getPlayer()->getNameTag()
        );
    }
}