<?php


namespace SnakeTn\JwtSecurityBundle\Security;


use Firebase\JWT\JWT;
use UnexpectedValueException;

class UserProvider
{
    public function getUserFromToken($token)
    {
        $token = preg_replace('/^Bearer /', '', $token);
        $decodedToken = JWT::decode($token, 'some_key', ['HS256']);
        if (!isset($decodedToken->user_location)) {
            throw new UnexpectedValueException('Username is missing');
        }
        $user = new User($decodedToken->user_location);
        return $user;
    }
}