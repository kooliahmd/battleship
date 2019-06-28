<?php


namespace App;


use App\Instuctions\InitBoardInstruction;
use App\Instuctions\ShootInstruction;

class GameController
{
    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function initBoard(Player $player, InitBoardInstruction $instruction)
    {
        $game = $this->gameRepository->loadByPlayer($player);
        $game->initBoard($player, $instruction);
    }

    public function executeShoot(Player $player, ShootInstruction $instruction)
    {
        $game = $this->gameRepository->loadByPlayer($player);
        $game->executeShoot($player, $instruction);

        if(!$game->isInprogress()){
            $this->gameRepository->delete($game);
        }
    }

}