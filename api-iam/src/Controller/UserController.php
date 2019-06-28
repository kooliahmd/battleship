<?php


namespace App\Controller;


use App\Dto\User as UserDto;
use App\Entity\User as UserEntity;
use Doctrine\ORM\EntityManagerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    /**
     * @param UserDto $userDto
     * @Route(path="/users", methods={"post"})
     * @ParamConverter(name="userDto", converter="app.request_body_converter")
     */
    public function create(UserDto $userDto)
    {
        $userEntity = new UserEntity();
        $userEntity->setPasswordHash(password_hash($userDto->getPassword(),PASSWORD_BCRYPT));
        $userEntity->setUsername($userDto->getUsername());
        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();
    }
}