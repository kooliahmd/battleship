<?php


namespace App\Board;


class ShootImpact
{

    /** @var Position[] */
    private $misses = [];

    /** @var Position[] */
    private $hits = [];

    /** @var Unit[] */
    private $destroyedUnits = [];

    public function addMiss(Position $miss)
    {
        $this->misses[] = $miss;
    }

    public function addHit(Position $hit)
    {
        $this->hits[] = $hit;
    }

    public function addDestroyedUnit(Unit $destroyedUnit)
    {
        $this->destroyedUnits[] = $destroyedUnit;
    }

    /**
     * @return Position[]
     */
    public function getMisses(): array
    {
        return $this->misses;
    }

    /**
     * @return Position[]
     */
    public function getHits(): array
    {
        return $this->hits;
    }

    /**
     * @return Unit[]
     */
    public function getDestroyedUnits(): array
    {
        return $this->destroyedUnits;
    }

}