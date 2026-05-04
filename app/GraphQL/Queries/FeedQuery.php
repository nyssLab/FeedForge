<?php

namespace App\GraphQL\Queries;

use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

final class FeedQuery
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    public function builder(mixed $_, array $args): Builder
    {
        return $this->postRepository->feedQuery();
    }
}
