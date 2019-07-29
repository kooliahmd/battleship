<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;

use Firebase\JWT\JWT;

class TokenGenerator
{
    const JWT_SECRET_KEY = 'some_key';
    const JWT_ALG = 'HS256';

    public function generate(User $user): string
    {
        return JWT::encode(
            [
                'user_location' => $user->getLocation(),
                'user_id' => $user->getUsername()
            ],
            self::JWT_SECRET_KEY,
            self::JWT_ALG
        );
    }
}