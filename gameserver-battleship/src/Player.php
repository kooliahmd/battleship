<?php

namespace App;

use App\Board\ShootImpact;
use Ratchet\ConnectionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class Player
{

    /** @var string */
    private $userLocation;

    /** @var ConnectionInterface */
    private $connection;

    /*
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param string $userLocation
     * @param ConnectionInterface $connection
     */
    public function __construct(string $userLocation, ConnectionInterface $connection)
    {
        $this->userLocation = $userLocation;
        $this->connection = $connection;
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    /** @return ConnectionInterface */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getUserLocation(): string
    {
        return $this->userLocation;
    }

    public function sendOpponentBoardInitialized()
    {
        $this->getConnection()->send($this->serializer->serialize(["type" => "opponent-finish-board-init"], 'json'));
    }

    public function sendSelfShootImpact(ShootImpact $impact)
    {
        $normalizedImpact = $this->serializer->normalize($impact);
        $normalizedImpact["destroyed_units"] = $normalizedImpact["destroyedUnits"];
        unset($normalizedImpact["destroyedUnits"]);
        $normalizedImpact["type"] = "player-shoot-impact";

        $this->getConnection()->send($this->serializer->serialize($normalizedImpact, 'json'));
    }

    public function sendOpponentShootImpact(ShootImpact $impact)
    {
        $normalizedImpact = $this->serializer->normalize($impact);
        $normalizedImpact["destroyed_units"] = $normalizedImpact["destroyedUnits"];
        unset($normalizedImpact["destroyedUnits"]);
        $normalizedImpact["type"] = "opponent-shoot-impact";

        $this->getConnection()->send($this->serializer->serialize($normalizedImpact, 'json'));
    }

    public function sendOpponentIsConnected(){
        $this->getConnection()->send($this->serializer->serialize(["type" => "opponent-connected"], 'json'));
    }

    public function sendYouWon()
    {
        $this->getConnection()->send($this->serializer->serialize(["type" => "you-won"], 'json'));
    }
    public function sendYouLost()
    {
        $this->getConnection()->send($this->serializer->serialize(["type" => "you-lost"], 'json'));
    }
}