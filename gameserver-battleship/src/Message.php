<?php

namespace App;

class Message
{
    private $instruction;
    private $action;

    /**
     * Message constructor.
     * @param $instruction
     * @param $action
     */
    public function __construct($action, $instruction)
    {
        $this->action = $action;
        $this->instruction = $instruction;
    }


    /**
     * @return mixed
     */
    public function getInstruction()
    {
        return $this->instruction;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }


}