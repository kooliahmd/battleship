<?php


namespace App;


use App\Board\Board;
use App\Instuctions\InitBoardInstruction;
use App\Instuctions\ShootInstruction;

class Game
{
    /**
     * @var string
     */
    private $location;

    /* @var Player */
    private $player1;

    /* @var Player */
    private $player2;

    /* @var Board */
    private $board1;

    /* @var Board */
    private $board2;

    private $isInprogress = false;

    /**
     * Game constructor.
     * @param string $location
     * @param Player $player
     */
    public function __construct(string $location, Player $player)
    {
        $this->location = $location;
        $this->player1 = $player;
    }

    public function setPlayer2(Player $player)
    {
        $this->player2 = $player;
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        $players = [$this->player1];
        if ($this->player2) {
            $players[] = $this->player2;
        }
        return $players;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    public function initBoard(Player $player, InitBoardInstruction $instruction)
    {
        $board = new Board($instruction->getUnits());

        if ($player === $this->player1) {
            $this->board1 = $board;
            $this->player2->sendOpponentBoardInitialized();

        } elseif ($player === $this->player2) {
            $this->board2 = $board;
            $this->player1->sendOpponentBoardInitialized();
        } else {
            throw new \Exception('can not init board: player not part of the game');
        }
    }

    public function executeShoot(Player $player, ShootInstruction $instruction)
    {
        if ($player === $this->player1) {
            $targetBoard = $this->board2;
            $targetPlayer = $this->player2;
        } elseif ($player === $this->player2) {
            $targetBoard = $this->board1;
            $targetPlayer = $this->player1;
        } else {
            throw new \Exception('can not exec shoot: player not part of the game');
        }

        $impact = $targetBoard->receiveShoot($instruction->getPosition());
        $targetPlayer->sendOpponentShootImpact($impact);
        $player->sendSelfShootImpact($impact);

        if ($targetBoard->isAllDestroyed()) {
            $player->sendYouWon();
            $targetPlayer->sendYouLost();
            $this->endGame();
        }
    }

    public function canStart()
    {
        return isset($this->player2);
    }

    public function start()
    {
        $this->player1->sendOpponentIsConnected();
        $this->player2->sendOpponentIsConnected();
        $this->isInprogress = true;
    }

    public function endGame()
    {
        $this->isInprogress = false;
    }
    public function isInprogress()
    {
        return $this->isInprogress;
    }

}