<?php

namespace App\Dto;

class User
{
    private $username;
    private $password;


    public function getUsername(): string
    {
        return $this->username;
    }


}