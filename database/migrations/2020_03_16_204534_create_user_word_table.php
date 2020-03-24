<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_word', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('word_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('learned_times')->default(0);
            $table->unsignedInteger('last_time_learned');
            $table->foreign('word_id')->references('id')->on('words');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique('word_id', 'user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('user_word');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
