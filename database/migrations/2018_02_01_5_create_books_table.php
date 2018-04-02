<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('book_id');
            $table->string('title');
            $table->string('ISBN');
            $table->text('description');
            $table->text('image');
            $table->integer('publication_year');
            $table->decimal('price');
            $table->integer('stock_level');
            $table->unsignedInteger('author_id')->nullable();
            $table->unsignedInteger('publisher_id')->nullable();
            $table->unsignedInteger('genre_id')->nullable();
            $table->unsignedInteger('type_id')->nullable();
            $table->timestamps();

            $table->foreign('author_id')
                ->references('author_id')
                ->on('authors')
                ->onDelete('cascade');
            $table->foreign('publisher_id')
                ->references('publisher_id')
                ->on('publishers')
                ->onDelete('cascade');
            $table->foreign('genre_id')
                ->references('genre_id')
                ->on('genre')
                ->onDelete('cascade');
            $table->foreign('type_id')
                ->references('type_id')
                ->on('type')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
