<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->string('author')->default('')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('title')->default('')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('content')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->decimal('likes')->default(0);
            $table->json('category_id');
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
        Schema::dropIfExists('posts');
    }
}
