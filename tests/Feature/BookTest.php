<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Author;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_book()
    {
        $author = Author::factory()->create();

        $data = [
            'title' => 'Harry Potter and the Philosopher\'s Stone',
            'description' => 'A fantasy novel about a young wizard.',
            'publish_date' => '1997-06-26',
            'author_id' => $author->id,
        ];

        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(201)
            ->assertJson(['isSuccess' => true]);

        $this->assertDatabaseHas('books', $data);
    }

    /** @test */
    public function it_can_get_a_list_of_books()
    {
        $books = Book::factory()->count(5)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJson(['isSuccess' => true]);
    }

    /** @test */
    public function it_can_get_detail_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJson([
                'isSuccess' => true,
            ]);
    }

    /** @test */
    public function it_can_update_a_book()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create();
        $data = [
            'title' => 'Updated Book Title',
            'description' => 'Updated Description',
            'publish_date' => '2000-01-01',
            'author_id' => $author->id
        ];

        $response = $this->putJson("/api/books/{$book->id}", $data);

        $response->assertStatus(200)
            ->assertJson(['isSuccess' => true]);

        $this->assertDatabaseHas('books', $data);
    }

    /** @test */
    public function it_can_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJson(['isSuccess' => true]);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
