<?php

namespace App\Board;

class Unit
{
    /** @var Position */
    private $position;

    /** @var int */
    private $orientation;

    /** @var int */
    private $size;

    /** @var Position[] */
    private $hits = [];

    /**
     * Unit constructor.
     * @param $position
     * @param $orientation
     * @param $size
     */
    public function __construct($position, $orientation, $size)
    {
        $this->position = $position;
        $this->orientation = $orientation;
        $this->size = $size;
    }

    public function receiveShoot(Position $shootPosition): bool
    {
        foreach ($this->getOccupiedSlots() as $occupiedSlot) {
            if ($occupiedSlot == $shootPosition) {
                $this->appendHit($shootPosition);
                return true;
            }
        }
        return false;
    }

    public function isDestroyed(): bool
    {
        return count($this->hits) === $this->size;
    }

    /**
     * @return Position[]
     */
    private function getOccupiedSlots(): array
    {
        $occupiedSlots = [];
        for ($index = 0; $index < $this->size; $index++) {
            switch ($this->orientation) {
                case Orientation::N:
                    $occupiedSlots[] = new Position($this->position->getX(), $this->position->getY() + $index);
                    break;
                case Orientation::S:
                    $occupiedSlots[] = new Position($this->position->getX(), $this->position->getY() - $index);
                    break;
                case Orientation::E:
                    $occupiedSlots[] = new Position($this->position->getX() + $index, $this->position->getY());
                    break;
                case Orientation::W:
                    $occupiedSlots[] = new Position($this->position->getX() - $index, $this->position->getY());
                    break;
            }
        }
        return $occupiedSlots;
    }


    private function appendHit($shootPosition): void
    {
        if (!in_array($shootPosition, $this->hits)) {
            $this->hits[] = $shootPosition;
        }
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getOrientation(): string
    {
        switch ($this->orientation) {
            case Orientation::E:
                return 'e';
            case Orientation::S:
                return 's';
            case Orientation::W:
                return 'w';
            case Orientation::N:
                return 'n';
        }
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }


}