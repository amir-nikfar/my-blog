<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;


class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_all_posts()
    {
        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
    }

    public function test_view_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = $user->posts()->save(Post::factory()->make());

        $response = $this->get(route('posts.show', $post->id));
        $response->assertStatus(200);
    }

    public function test_create_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('posts.store', [
            'title' => 'New title',
            'body' => 'New body',
            'user_id' => Auth::id()
        ]));

        $response->assertStatus(302);

        $post = Post::first();

        $this->assertEquals(1, Post::count());
        $this->assertEquals('New title', $post->title);
        $this->assertEquals('New body', $post->body);
        $this->assertEquals($user->id, $post->user->id);
        $this->assertInstanceOf(User::class, $post->user);
    }

    public function test_update_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => Auth::id()]);

        $response = $this->put(route('posts.update', $post->id), [
            'title' => 'Updated title',
            'body' => 'Updated body',
        ]);

        $post = $post->fresh();

        $response->assertStatus(302);

        $this->assertEquals(1, Post::count());
        $this->assertEquals('Updated title', $post->title);
        $this->assertEquals('Updated body', $post->body);
        $this->assertEquals($user->id, $post->user->id);
        $this->assertInstanceOf(User::class, $post->user);
    }

    public function test_form_validation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create([
            'title' => 'this is a title',
            'body'=> 'this is a body',
            'user_id' => Auth::id()
        ]);

        $titleResponse = $this->post(route('posts.store'), array_merge($post->toArray(), ['title' => '']));
        $bodyResponse = $this->post(route('posts.store'), array_merge($post->toArray(), ['body' => '']));

        $titleResponse->assertSessionHasErrors();
        $bodyResponse->assertSessionHasErrors();
    }
}
