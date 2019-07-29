<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Dto\Room as RoomDto;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 */
class Room
{
    static function createFromDto(RoomDto $roomDto)
    {
        $room = new self();
        $room->title = $roomDto->getTitle();
        $room->host = $roomDto->getHost();
        return $room;
    }

    private function __construct()
    {
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $host;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $guest;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @param string $guest
     */
    public function setGuest(string $guest): void
    {
        $this->guest = $guest;
    }

    public function clearGuest()
    {
        $this->guest = null;
    }

    public function canAcceptGuest(): bool
    {
        return !empty($this->guest);
    }

    public function hasGuest($guestLocation)
    {
        return $this->guest === $guestLocation;
    }

    public function isHostedBy($userLocation)
    {
        return $this->host === $userLocation;
    }

}
