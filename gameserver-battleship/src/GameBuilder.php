<?php


namespace App;


use App\Exception\NotFoundException;

class GameBuilder
{

    /* @var string */
    private $location;

    /* @var Player */
    private $player;

    /* @var PlayerRepository */
    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function setLocation(string $location)
    {
        $this->location = $location;
        return $this;
    }

    public function addPlayer(Player $player)
    {
        $this->player = $player;
        return $this;

    }

    public function build()
    {
        try {
            $game = $this->gameRepository->load($this->location);
            if (count($game->getPlayers()) === 2) {
                throw new \Exception("can not set player2, slot is occupied");
            }
            $game->setPlayer2($this->player);
        } catch (NotFoundException $e) {
            $game = new Game($this->location, $this->player);
        }
        return $game;
    }


}