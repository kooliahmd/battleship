<?php


namespace App\Instuctions;


class ShootInstruction
{
    private $position;

    /**
     * ShootInstruction constructor.
     * @param $position
     */
    public function __construct($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }


}