<?php

namespace App\Controller;

use App\Dto\Game as GameDto;
use App\Dto\ResourceId;
use App\Entity\Game;

use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SnakeTn\JwtSecurityBundle\Security\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class GameController
{
    private $entityManager;
    private $gameRepository;

    public function __construct(EntityManagerInterface $em, GameRepository $gameRepository)
    {
        $this->entityManager = $em;
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Route(path="/game", methods={"post"})
     * @ParamConverter(name="gameDto", converter="snaketn.api.request_body_converter")
     * @param GameDto $gameDto
     */
    public function create(GameDto $gameDto, Security $security)
    {
        /*** @var $user User */
        $user = $this->getUser($security);

        if ($gameDto->getHost() != $user->getUsername()) {
            throw new AccessDeniedHttpException('user not allowed to create a game using other\'s host');
        }

        $game = Game::createFromDto($gameDto);

        $game->setStatus(Game::STATUS_WAITING_FOR_GUEST);
        $this->entityManager->persist($game);
        $this->entityManager->flush();
        return new ResourceId((string)$game->getId());
    }

    /**
     * @Route(path="/game/{host}/guest/self", methods={"post"})
     */
    public function join(string $host, Security $security)
    {
        $game = $this->gameRepository->findOneBy(['host' => $host, 'status' => Game::STATUS_WAITING_FOR_GUEST]);
        if (empty($game)) {
            throw new NotFoundHttpException('game not found');
        }

        /*** @var $user User */
        $user = $this->getUser($security);

        $game->setGuest($user->getUsername());
        $game->setStatus(Game::STATUS_IN_PROGRESS);

        $this->entityManager->flush();
        return new ResourceId((string)$game->getId());
    }

    /**
     * @param Security $security
     * @return User
     */
    private function getUser(Security $security): User
    {
        return $security->getUser();
    }

}