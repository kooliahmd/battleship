<?php

namespace App;

use Ratchet\ConnectionInterface;

class PlayerRepository
{
    /** @var Player[] */
    private $players = [];

    public function save(Player $player): void
    {
        $this->players[spl_object_hash($player->getConnection())] = $player;
    }

    public function loadByConnection(ConnectionInterface $connection): Player
    {
        if (isset($this->players[spl_object_hash($connection)])) {
            return $this->players[spl_object_hash($connection)];
        }
        throw new \Exception("player not found");
    }
}