<?php

namespace App\Controller;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Dto\Player as PlayerDto;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PlayerController
{
    private $httpClient;
    private $serializer;
    private $entityManager;

    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        HttpClientInterface $httpClient,
        PlayerRepository $playerRepository

    )
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
        $this->playerRepository = $playerRepository;
    }

    /**
     * @Route(path="/player", methods={"post"})
     * @ParamConverter(name="playerDto", converter="snaketn.api.request_body_converter")
     */
    public function create(PlayerDto $playerDto)
    {
        $player = new Player($playerDto->getUser()->getUsername());
        $this->entityManager->persist($player);
        $this->entityManager->flush();

        $response = $this->httpClient->request(
            'POST',
            'http://api-iam_nginx/users',
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => $this->serializer->serialize($playerDto->getUser(), 'json')]
        );
        $response->getContent();
        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route(path="/player/{username}", methods={"get"})
     */
    public function get($username){
        $player = $this->playerRepository->find($username);
        if(!$player){
            throw new NotFoundHttpException();
        }
        return $player;
    }
}