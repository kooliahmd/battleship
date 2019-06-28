<?php

namespace App\Board;

class Orientation
{
    const N = 2;
    const E = 1;
    const S = 4;
    const W = 3;

    private $value;

    public function __construct($value)
    {
        if (!in_array($value, [self::N, self::E, self::S, self::W])) {
            throw new \Exception("can not construct orientation");
        }
        $this->value = $value;
    }

}