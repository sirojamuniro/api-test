<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_a_list_of_authors()
    {
        Author::factory()->count(3)->create();
        $response = $this->getJson('/api/authors');
        $response->assertStatus(200)
            ->assertJson(['isSuccess' => true]);
    }

    /** @test */
    public function it_can_create_an_author()
    {
        $data = [
            'name' => 'John Doe',
            'bio' => 'Author bio',
            'birth_date' => '1985-05-05',
        ];

        $response = $this->postJson('/api/authors', $data);

        $response->assertStatus(201)
            ->assertJson(['isSuccess' => true]);

        $this->assertDatabaseHas('authors', $data);
    }

    /** @test */
    public function it_can_get_detail_author()
    {
        $author = Author::factory()->create();
        $response = $this->getJson("/api/authors/{$author->id}");

        $response->assertStatus(200)
            ->assertJson([
                'isSuccess' => true,
            ]);
    }

    /** @test */
    public function it_can_update_an_author()
    {
        $author = Author::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'bio' => 'Updated Bio',
            'birth_date' => '1990-01-01',
        ];

        $response = $this->putJson("/api/authors/{$author->id}", $data);

        $response->assertStatus(200)
            ->assertJson(['isSuccess' => true]);

        $this->assertDatabaseHas('authors', $data);
    }

    /** @test */
    public function it_can_delete_an_author()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}");

        $response->assertStatus(200)
            ->assertJson(['isSuccess' => true]);

        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
