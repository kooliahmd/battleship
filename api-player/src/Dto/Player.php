<?php


namespace App\Dto;


use JMS\Serializer\Annotation as Serializer;

class Player
{
    /**
     * @Serializer\Type("App\Dto\User")     
     */
    private $user;
}