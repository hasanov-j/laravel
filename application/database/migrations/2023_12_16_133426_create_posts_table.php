<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('slug',255);
            $table->text('description');
            $table->foreignId('category_id')->constrained('categories')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->boolean(column: 'is_publish')->default(0);
            $table->boolean(column: 'is_recommended')->default(0);
            $table->integer(column: 'views')->default(0);
            $table->string(column: 'image');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
