<?php

namespace App\Dto;

class Game
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $guest;

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getGuest(): ?string
    {
        return $this->guest;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @param string $guest
     */
    public function setGuest(?string $guest): void
    {
        $this->guest = $guest;
    }



}