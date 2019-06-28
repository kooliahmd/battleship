<?php

namespace App\Tests\Board;

use App\Board\Board;
use App\Board\Position;
use App\Board\ShootImpact;
use App\Board\Unit;
use App\Board\Orientation;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function test_receive_shoot_case_hit()
    {
        $board = $this->getBoard([$this->getUnit()]);

        $shootImpact = $board->receiveShoot(new Position(1, 1));

        $expectedImpact = new ShootImpact();
        $expectedImpact->addHit(new Position(1, 1));

        $this->assertEquals($expectedImpact, $shootImpact);
    }

    public function test_receive_shoot_case_unit_destroyed()
    {
        $unit = $this->getUnit();
        $board = $this->getBoard([$unit]);
        $board->receiveShoot(new Position(1, 1));
        $board->receiveShoot(new Position(1, 2));
        $shootImpact = $board->receiveShoot(new Position(1, 3));

        $this->assertEquals([$unit], $shootImpact->getDestroyedUnits());

    }

    public function test_receive_shoot_case_miss()
    {
        $board = $this->getBoard([$this->getUnit()]);
        $shootImpact = $board->receiveShoot(new Position(1, 4));

        $expectedImpact = new ShootImpact();
        $expectedImpact->addMiss(new Position(1, 4));

        $this->assertEquals($expectedImpact, $shootImpact);
    }

    /**
     * @return Board
     */
    public function getBoard($units): Board
    {
        $board = new Board($units);
        return $board;
    }

    /**
     * @return Unit
     */
    public function getUnit(): Unit
    {
        $unit = new Unit(
            new Position(1, 1),
            Orientation::N,
            3
        );
        return $unit;
    }

}