<?php

namespace App\Dto;

class Room
{

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $host;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }


}