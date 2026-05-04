<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

final class PostRepository implements PostRepositoryInterface
{
    public function create(int $userId, string $body): Post
    {
        return Post::create([
            'user_id' => $userId,
            'body'    => $body,
        ]);
    }

    public function feedQuery(): Builder
    {
        return Post::query()
            ->latest();
    }
}
