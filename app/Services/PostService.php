<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;

final class PostService
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    public function createPost(Authenticatable $user, string $body): Post
    {
        return $this->postRepository->create(
            userId: $user->getAuthIdentifier(),
            body: $body,
        );
    }
}
