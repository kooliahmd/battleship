<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * Player constructor.
     * @param $username
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

}