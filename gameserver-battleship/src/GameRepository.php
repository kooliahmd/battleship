<?php

namespace App;

use App\Exception\NotFoundException;

class GameRepository
{
    /** @var Game[] */
    private $games = [];

    private $playerIndex;

    public function save(Game $game): void
    {
        $this->games[$game->getLocation()] = $game;

        $this->updatePlayerIndex($game);
    }

    public function delete(Game $game): void
    {
        unset($this->games[$game->getLocation()]);
    }

    public function load(string $gameLocation): Game
    {
        if (isset($this->games[$gameLocation])) {
            return $this->games[$gameLocation];
        }
        throw new NotFoundException("game not found");
    }

    public function loadByPlayer(Player $player): Game
    {
        if (isset($this->playerIndex[$player->getUserLocation()])) {
            return $this->playerIndex[$player->getUserLocation()];
        }
        throw new NotFoundException("player not found");
    }

    /**
     * @param Game $game
     */
    private function updatePlayerIndex(Game $game): void
    {
        foreach ($game->getPlayers() as $player) {
            $this->playerIndex[$player->getUserLocation()] = $game;
        }
    }
}