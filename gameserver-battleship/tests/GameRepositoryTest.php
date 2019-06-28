<?php


namespace App\Tests;


use App\Game;
use App\GameRepository;
use App\Player;
use PHPUnit\Framework\TestCase;


class GameRepositoryTest extends TestCase
{

    public function test_load_by_location()
    {
        $gameRepository = new GameRepository;
        $game = new Game('dump_g_location', $this->createMock(Player::class));

        $gameRepository->save($game);

        $this->assertEquals($game, $gameRepository->load('dump_g_location'));;
    }
}