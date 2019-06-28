<?php


class Player
{
    /**
     * @var string
     */
    private $username;

    /**
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }


    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }


}