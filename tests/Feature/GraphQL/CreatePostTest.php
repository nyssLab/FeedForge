<?php

namespace Tests\Feature\GraphQL;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;
use Tests\TestCase;

final class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    private const MUTATION = /** @lang GraphQL */ <<<'GQL'
        mutation CreatePost($body: String!) {
            createPost(input: { body: $body }) {
                id
                body
                author {
                    username
                }
            }
        }
    GQL;

    public function test_authenticated_user_can_create_a_post(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->graphQL(self::MUTATION, ['body' => 'Hello, world!'])
            ->assertJson([
                'data' => [
                    'createPost' => [
                        'body' => 'Hello, world!',
                        'author' => ['username' => $user->username],
                    ],
                ],
            ]);
    }

    public function test_post_body_cannot_exceed_280_characters(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->graphQL(self::MUTATION, ['body' => str_repeat('a', 281)])
            ->assertGraphQLValidationError('input.body', 'A post cannot exceed 280 characters.');
    }

    public function test_unauthenticated_user_cannot_create_a_post(): void
    {
        $this->graphQL(self::MUTATION, ['body' => 'Sneaky post'])
            ->assertGraphQLError(new AuthenticationException);

    }
}
