<?php

namespace App\GraphQL\Mutations;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Exceptions\AuthorizationException;

final class CreatePostMutation
{
    public function __construct(
        private readonly PostService $postService,
    ) {}

    /**
     * @param  null  $_
     * @param  array{body: string}  $args
     */
    public function resolve(mixed $_, array $args): Post
    {
        $user = Auth::user() ?? throw new AuthorizationException();

        return $this->postService->createPost($user, $args['body']);
    }
}
