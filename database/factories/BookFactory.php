<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $stock = fake()->numberBetween(3, 15);

        return [
            'category_id' => Category::factory(),
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'publication_year' => fake()->numberBetween(2015, 2024),
            'isbn' => fake()->isbn13(),
            'stock' => $stock,
            'available_stock' => $stock,
            'shelf_location' => 'Rak '.fake()->randomElement(['A', 'B', 'C', 'D']).'-'.fake()->numberBetween(1, 10),
            'description' => fake()->paragraph(),
            'cover_image' => null,
        ];
    }
}
