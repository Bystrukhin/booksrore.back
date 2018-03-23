<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new \App\Book([
            'title' => 'Harry Potter',
            'ISBN' => 1,
            'description' => 'Super cool - at least as a child.',
            'publication_year' => '01.01.01',
            'price' => 10
        ]);
        $product->save();

        $product = new \App\Book([
            'title' => 'A Song of Ice and Fire - A Storm of Swords',
            'ISBN' => 2,
            'description' => 'No one is going to survive!',
            'publication_year' => '01.01.01',
            'price' => 10
        ]);
        $product->save();

        $product = new \App\Book([
            'title' => 'Lord of the Rings',
            'ISBN' => 3,
            'description' => 'I found the movies to be better ...',
            'publication_year' => '01.01.01',
            'price' => 20
        ]);
        $product->save();

        $product = new \App\Book([
            'title' => 'A Song of Ice and Fire - Game of Thrones',
            'ISBN' => 4,
            'description' => 'No one is going to survive!',
            'publication_year' => '01.01.01',
            'price' => 20
        ]);
        $product->save();

        $product = new \App\Book([
            'title' => 'A Song of Ice and Fire - A Feast for Crows',
            'ISBN' => 5,
            'description' => 'Still, no one is going to survive!',
            'publication_year' => '01.01.01',
            'price' => 20
        ]);
        $product->save();
    }
}
