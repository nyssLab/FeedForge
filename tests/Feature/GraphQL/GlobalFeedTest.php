<?php

namespace Tests\Feature\GraphQL;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GlobalFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_feed_returns_paginated_posts(): void
    {
        User::factory()
            ->hasPosts(20)
            ->create();

        $this->graphQL(/** @lang GraphQL */ '
            {
                feed(first: 10) {
                    data {
                        id
                        body
                        author { username }
                    }
                    paginatorInfo {
                        total
                        hasMorePages
                    }
                }
            }
        ')
            ->assertJsonCount(10, 'data.feed.data')
            ->assertJson([
                'data' => [
                    'feed' => [
                        'paginatorInfo' => [
                            'total' => 20,
                            'hasMorePages' => true,
                        ],
                    ],
                ],
            ]);
    }
}
