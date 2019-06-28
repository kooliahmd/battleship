<?php


namespace App\Consumer;


use App\Controller\UserController;
use App\Dto\Player;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\SerializerInterface;

class PlayerCreatedConsumer implements ConsumerInterface
{

    private $userController;
    private $serializer;

    public function __construct(UserController $userController, SerializerInterface $serializer)
    {
        $this->userController = $userController;
        $this->serializer = $serializer;
    }

    public function execute(AMQPMessage $msg)
    {
        $serializedUser = $msg->getBody();
        $playerDto = $this->serializer->deserialize($serializedUser, Player::class, 'json');
        $this->userController->create($playerDto->getUser());
    }
}