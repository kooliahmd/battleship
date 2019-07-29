<?php

namespace App\Controller;

use App\Dto\Room as RoomDto;
use App\Entity\Room as RoomEntity;
use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use SnakeTn\JwtSecurityBundle\Security\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class RoomController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @Route(path="/rooms", methods={"POST"})
     * @ParamConverter(name="room", converter="app.request_body_converter")
     * @param RoomDto $room
     */
    public function open(RoomDto $room)
    {
        $roomEntity = RoomEntity::createFromDto($room);
        $this->entityManager->persist($roomEntity);
        $this->entityManager->flush();

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route(path="/rooms/{roomId}", methods={"DELETE"})
     */
    public function close($roomId, Security $security)
    {
        /*** @var $user User */
        $user = $this->getUser($security);
        $room = $this->getRoom($roomId);
        if (!$room->isHostedBy($user->getLocation())) {
            throw new AccessDeniedHttpException('room %s is not hosted by current user');
        }

        $this->entityManager->remove($room);

        $this->entityManager->flush();
        return new Response(null, Response::HTTP_OK);
    }

    /**
     * @Route(path="/rooms/", methods={"GET"})
     */
    public function getAll(){
        $repository = $this->entityManager->getRepository(Room::class);
        return $repository->findAll();
    }

    /**
     * @Route(path="/rooms/{roomId}/guest/self", methods={"POST"})
     */
    public function join($roomId, Security $security)
    {
        /*** @var $user User */
        $user = $this->getUser($security);
        $room = $this->getRoom($roomId);
        if ($room->canAcceptGuest()) {
            throw new AccessDeniedHttpException('no guest spot available');
        }

        $room->setGuest($user->getUsername());

        $this->entityManager->flush();
        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route(path="/rooms/{roomId}/guest", methods={"DELETE"})
     */
    public function leave($roomId, Security $security)
    {
        /*** @var $user User */
        $user = $this->getUser($security);
        $room = $this->getRoom($roomId);
        if (!$room->hasGuest($user->getLocation())) {
            throw new AccessDeniedHttpException(sprintf('user is not into room %s', $roomId));
        }

        $room->clearGuest();

        $this->entityManager->flush();
        return new Response(null, Response::HTTP_OK);
    }

    /**
     * @param $roomId
     * @return Room
     */
    public function getRoom($roomId): Room
    {
        $repository = $this->entityManager->getRepository(Room::class);
        /** @var $room Room */
        $room = $repository->find($roomId);
        if (empty($room)) {
            throw new NotFoundHttpException(sprintf('room %s not found', $roomId));
        }
        return $room;
    }

    /**
     * @param Security $security
     * @return User
     */
    public function getUser(Security $security): User
    {
        return $security->getUser();
    }
}