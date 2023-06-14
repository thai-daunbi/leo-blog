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
        Schema::create('like_controls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('like_user_id');
            $table->unsignedBigInteger('like_post_id');
            $table->timestamps();

            $table->foreign('like_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('like_post_id')->references('id')->on('posts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_controls');
    }
};
