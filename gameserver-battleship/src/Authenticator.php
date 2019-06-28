<?php


namespace App;


use GuzzleHttp\Psr7\Request;

class Authenticator
{
    public function authenticate(Request $httpRequest)
    {
        $query = $httpRequest->getUri()->getQuery();
        parse_str($query, $params);
        if (empty($params['access_token'])) {
            throw new \Exception("invalid token");
        }
        $user = $params['access_token'];
        return $user;
    }
}