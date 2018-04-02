<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('comment_id');
            $table->text('text');
            $table->integer('visible')->nullable();
            $table->integer('vote')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('book_id')->nullable();
            $table->dateTime('date');

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('book_id')
                ->references('book_id')
                ->on('books')
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
        Schema::dropIfExists('comments');
    }
}
