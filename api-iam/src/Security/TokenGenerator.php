<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;

use Firebase\JWT\JWT;

class TokenGenerator
{
    const JWT_PRIVATE_KEY = 'some_key';
    const JWT_ALG = 'HS256';

    public function generate(User $user): string
    {
        return JWT::encode(
            [
                'user_location' => $user->getLocation()
            ],
            self::JWT_PRIVATE_KEY,
            self::JWT_ALG
        );
    }
}