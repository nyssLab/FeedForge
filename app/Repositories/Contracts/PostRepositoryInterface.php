<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

interface PostRepositoryInterface
{
    public function create(int $userId, string $body): Post;
    public function feedQuery(): Builder;
}
