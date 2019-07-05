<?php

namespace App\Controller;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Dto\Player as PlayerDto;
use Symfony\Component\Serializer\SerializerInterface;

class PlayerController
{

    /**
     * @var ProducerInterface
     */
    private $producer;
    private $serializer;

    public function __construct($producer, SerializerInterface $serializer)
    {
        $this->producer = $producer;
        $this->serializer = $serializer;
    }

    /**
     * @Route(path="/player", methods={"post"})
     * @ParamConverter(name="playerDto", converter="snaketn.api.request_body_converter")
     */
    public function create(PlayerDto $playerDto)
    {
        $this->producer->publish($this->serializer->serialize($playerDto, 'json'));
        return new Response(null, Response::HTTP_CREATED);
    }
}