<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class User
{

    /**
     * @Serializer\Type("string")
     */
    private $username;

    /**
     * @Serializer\Type("string")
     */
    private $password;

}