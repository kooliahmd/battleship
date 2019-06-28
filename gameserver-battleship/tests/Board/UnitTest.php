<?php

namespace App\Tests\Board;

use App\Board\Orientation;
use App\Board\Position;
use App\Board\Unit;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    public function test_receive_shoot_north_case()
    {
        $unit = new Unit(new Position(1, 1), Orientation::N, 2);
        $shootImpact1 = $unit->receiveShoot(new Position(1, 1));
        $shootImpact2 = $unit->receiveShoot(new Position(1, 2));
        $shootImpact3 = $unit->receiveShoot(new Position(1, 3));
        $shootImpact4 = $unit->receiveShoot(new Position(2, 3));
        $this->assertEquals(true, $shootImpact1);
        $this->assertEquals(true, $shootImpact2);
        $this->assertEquals(false, $shootImpact3);
        $this->assertEquals(false, $shootImpact4);
    }

    public function test_receive_shoot_south_case()
    {
        $unit = new Unit(new Position(3, 3), Orientation::S, 2);
        $shootImpact1 = $unit->receiveShoot(new Position(3, 3));
        $shootImpact2 = $unit->receiveShoot(new Position(3, 2));
        $shootImpact3 = $unit->receiveShoot(new Position(3, 4));
        $shootImpact4 = $unit->receiveShoot(new Position(0, 0));
        $this->assertEquals(true, $shootImpact1);
        $this->assertEquals(true, $shootImpact2);
        $this->assertEquals(false, $shootImpact3);
        $this->assertEquals(false, $shootImpact4);
    }

    public function test_receive_shoot_east_case()
    {
        $unit = new Unit(new Position(2, 2), Orientation::E, 2);
        $shootImpact1 = $unit->receiveShoot(new Position(2, 2));
        $shootImpact2 = $unit->receiveShoot(new Position(3, 2));
        $shootImpact3 = $unit->receiveShoot(new Position(1, 2));
        $shootImpact4 = $unit->receiveShoot(new Position(2, 3));
        $this->assertEquals(true, $shootImpact1);
        $this->assertEquals(true, $shootImpact2);
        $this->assertEquals(false, $shootImpact3);
        $this->assertEquals(false, $shootImpact4);
    }

    public function test_receive_shoot_west_case()
    {
        $unit = new Unit(new Position(3, 3), Orientation::W, 2);
        $shootImpact1 = $unit->receiveShoot(new Position(3, 3));
        $shootImpact2 = $unit->receiveShoot(new Position(2, 3));
        $shootImpact3 = $unit->receiveShoot(new Position(1, 3));
        $shootImpact4 = $unit->receiveShoot(new Position(4, 4));
        $this->assertEquals(true, $shootImpact1);
        $this->assertEquals(true, $shootImpact2);
        $this->assertEquals(false, $shootImpact3);
        $this->assertEquals(false, $shootImpact4);
    }
}