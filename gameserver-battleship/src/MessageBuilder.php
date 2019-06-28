<?php

namespace App;

use App\Board\Orientation;
use App\Board\Position;
use App\Board\Unit;
use App\Instuctions\InitBoardInstruction;
use App\Instuctions\ShootInstruction;

class MessageBuilder
{

    public function build(string $serializedMessage)
    {
        $message = json_decode($serializedMessage, true);

        switch ($message['type']) {
            case 'init-board':
                $instruction = $this->buildInitBoardInstruction($message['instruction']);
                break;
            case 'exec-shoot':
                $instruction = $this->buildShootInstruction($message['instruction']);
                break;
            default:
                throw new \Exception('can not build message: unknown instruction');
        }

        return new Message($message['type'], $instruction);
    }

    private function buildInitBoardInstruction($instructionMessage)
    {
        $units = [];
        foreach ($instructionMessage as $unitMessage) {

            $units[] = new Unit(
                new Position($unitMessage['position']['x'], $unitMessage['position']['y']),
                $this->mapOrientation($unitMessage['orientation']),
                $unitMessage['size']
            );

        }
        return new InitBoardInstruction($units);
    }

    private function buildShootInstruction($instructionMessage)
    {
        return new ShootInstruction(new Position($instructionMessage['x'], $instructionMessage['y']));
    }

    private function mapOrientation($orientationMessage)
    {
        switch ($orientationMessage) {
            case 'n':
                return Orientation::N;
            case 'w':
                return Orientation::W;
            case 's':
                return Orientation::S;
            case 'e':
                return Orientation::E;
        }
    }
}