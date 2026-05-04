<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

class Login
{
    public function __invoke(mixed $root, array $args): string
    {
        $user = User::where('email', $args['email'])->first();

        if (! $user || ! Hash::check($args['password'], $user->password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        return $user->createToken('api')->plainTextToken;
    }
}
