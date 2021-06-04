<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->string('login')->unique()->default('')->collation('utf8mb4_general_ci');;
            $table->string('real_name')->default('')->collation('utf8mb4_general_ci');;
            $table->string('email')->unique()->collation('utf8mb4_general_ci');;
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('password')->collation('utf8mb4_general_ci');;
            $table->decimal('rating')->default(0);
            $table->enum('role', ['user', 'admin'])->default('user')->charset('latin1')->collation('latin1_general_ci');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
