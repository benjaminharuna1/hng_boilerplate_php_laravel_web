<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\BlogCategory;
use Tymon\JWTAuth\Facades\JWTAuth;

class BlogCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_blog_category_with_valid_jwt()
    {
        $user = User::factory()->create([
            'role' => 'super-admin',
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/v1/blog-categories', [
            'name' => 'Tech'
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Blog category created successfully.',
                 ]);

        $this->assertDatabaseHas('blog_categories', [
            'name' => 'Tech',
        ]);
    }

    /** @test */
    public function it_prevents_non_super_admin_from_creating_blog_category()
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/v1/blog-categories', [
            'name' => 'Tech'
        ]);

        $response->assertStatus(403)
                 ->assertJson([
                     'status' => 'error',
                     'message' => 'Forbidden. You do not have permission to create blog categories.',
                 ]);
    }
}
