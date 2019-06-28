<?php

namespace App\Board;

class Board
{
    /** @var Unit[] */
    private $units;

    public function __construct($units)
    {
        $this->units = $units;
    }

    public function receiveShoot(Position $position): ShootImpact
    {
        $shootImpact = new ShootImpact();
        foreach ($this->units as $unit) {
            if ($unit->receiveShoot($position)) {
                $unit->isDestroyed() && $shootImpact->addDestroyedUnit($unit);
                $shootImpact->addHit($position);
                return $shootImpact;
            }
        }
        $shootImpact->addMiss($position);
        return $shootImpact;
    }

    public function isAllDestroyed()
    {
        foreach ($this->units as $unit) {
            if (!$unit->isDestroyed()) {
                return false;
            }
        }
        return true;
    }

}