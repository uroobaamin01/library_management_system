<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    }

    public function test_admin_can_create_book_with_copies(): void
    {
        $category = Category::factory()->create();
        $author = Author::factory()->create();
        $publisher = Publisher::factory()->create();
        $language = Language::factory()->create();

        $bookData = [
            'title' => 'Clean Code Architecture',
            'isbn' => '978-0132350884',
            'category_id' => $category->id,
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
            'language_id' => $language->id,
            'edition' => 1,
            'publish_year' => 2024,
            'price' => 45.99,
            'copies_count' => 5,
            'summary' => 'Software craftmanship manual.',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.books.store'), $bookData);

        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('books', ['isbn' => '978-0132350884']);
        
        $book = Book::where('isbn', '978-0132350884')->first();
        $this->assertCount(5, $book->copies);
    }

    public function test_admin_can_update_existing_book(): void
    {
        $book = Book::factory()->create(['title' => 'Old Title']);

        $response = $this->actingAs($this->admin)->put(route('admin.books.update', $book), [
            'title' => 'Updated Title',
            'isbn' => $book->isbn,
            'category_id' => $book->category_id,
            'author_id' => $book->author_id,
            'publisher_id' => $book->publisher_id,
            'language_id' => $book->language_id,
            'edition' => $book->edition,
            'price' => $book->price,
            'status' => 'available',
        ]);

        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Updated Title']);
    }
}