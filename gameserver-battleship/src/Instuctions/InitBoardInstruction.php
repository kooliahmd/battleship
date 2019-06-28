<?php


namespace App\Instuctions;


class InitBoardInstruction
{
    private $units;

    /**
     * InitBoardInstruction constructor.
     * @param $units
     */
    public function __construct(array $units)
    {
        $this->units = $units;
    }


    public function getUnits(): array
    {
        return $this->units;
    }


}