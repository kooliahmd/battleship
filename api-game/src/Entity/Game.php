<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Dto\Game as GameDto;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    public const STATUS_WAITING_FOR_GUEST = 'WAITING_FOR_GUEST';
    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const STATUS_OVER = 'OVER';


    static public function createFromDto(GameDto $gameDto): self
    {
        $game = new self();
        $game->setGuest($gameDto->getGuest())
            ->setHost($gameDto->getHost());
        return $game;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $host;

    /**
     * @ORM\Column(nullable=true, type="string", length=255)
     */
    private $guest;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getGuest(): ?string
    {
        return $this->guest;
    }

    public function setGuest(?string $guest): self
    {
        $this->guest = $guest;

        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

}
