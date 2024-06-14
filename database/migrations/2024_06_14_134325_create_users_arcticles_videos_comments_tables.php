<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('email');
            $table->char('password');
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->char('name');
            $table->char('url');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->char('name');
            $table->text('article');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->char('comment');
            $table->char('target_model');
            $table->smallInteger('target_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('comments');
    }
};
