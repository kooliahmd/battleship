<?php

namespace App\Controller;

use App\Dto\Game;
use App\Dto\Room as RoomDto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GameController
{

    /**
     * @Route(path="/game", methods={"post"})
     * @ParamConverter(name="game", converter="snaketn.api.request_body_converter")
     * @param RoomDto $room
     */
    public function create(Game $game)
    {

        $a = 1;

    }

}