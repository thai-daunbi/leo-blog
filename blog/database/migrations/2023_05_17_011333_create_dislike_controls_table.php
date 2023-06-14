<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dislike_controls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dislike_user_id');
            $table->unsignedBigInteger('dislike_post_id');
            $table->timestamps();

            $table->foreign('dislike_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('dislike_post_id')->references('id')->on('posts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dislike_controls');
    }
};
