<?php

namespace Tests\Feature\GraphQL;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    private const QUERY = /** @lang GraphQL */ <<<'GQL'
        query UserProfile($username: String!) {
            userProfile(username: $username) {
                id
                name
                username
                posts {
                    id
                    body
                }
            }
        }
    GQL;

    public function test_it_returns_user_with_posts(): void
    {
        User::factory()
            ->hasPosts(3)
            ->create(['username' => 'johndoe']);

        $this->graphQL(self::QUERY, ['username' => 'johndoe'])
            ->assertJson([
                'data' => [
                    'userProfile' => [
                        'username' => 'johndoe',
                    ],
                ],
            ])
            ->assertJsonCount(3, 'data.userProfile.posts');
    }

    public function test_it_returns_null_for_unknown_username(): void
    {
        $this->graphQL(self::QUERY, ['username' => 'nobody123456'])
            ->assertJson(['data' => ['userProfile' => null]]);
    }
}
