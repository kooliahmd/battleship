<?php

namespace SnakeTn\JwtSecurityBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private $id;

    /**
     * @param $location string
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    public function getRoles()
    {
        return ['ROLE_PLAYER'];
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
        return $this->id;
    }

    public function eraseCredentials()
    {
    }
}