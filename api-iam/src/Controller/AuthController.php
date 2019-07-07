<?php

namespace App\Controller;

use App\Dto\User as UserDto;
use App\Repository\UserRepository;
use App\Security\TokenGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Predis\Client;

class AuthController
{
    private $repository;
    private $tokenGenerator;


    public function __construct(
        UserRepository $repository,
        TokenGenerator $tokenGenerator
    )
    {
        $this->repository = $repository;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @Route(path="/authenticate", methods={"post"})
     * @ParamConverter(name="userDto", converter="snaketn.api.request_body_converter")
     * @param $userDto
     */
    public function authenticate(UserDto $userDto)
    {

        $userEntity = $this->repository->findOneBy(['username' => $userDto->getUsername()]);

        if (!$userEntity) {
            throw new HttpException(403);
        }
        $passwordVerification = password_verify($userDto->getPassword(), $userEntity->getPasswordHash());

        if (!$passwordVerification) {
            throw new HttpException(403);
        }

        $token = $this->tokenGenerator->generate($userEntity);

        return $token;
    }

}