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
        if (!isset($decodedToken->user_id)) {
            throw new UnexpectedValueException('User id is missing');
        }
        $user = new User($decodedToken->user_id);
        return $user;
    }
}