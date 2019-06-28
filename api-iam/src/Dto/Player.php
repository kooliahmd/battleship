<?php


namespace App\Dto;


use JMS\Serializer\Annotation as Serializer;

class Player
{

    /**
     * @Serializer\Type("App\Dto\User")
     * @var User
     */
    private $user;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }





}