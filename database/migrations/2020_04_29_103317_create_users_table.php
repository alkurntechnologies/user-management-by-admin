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
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email',150)->unique()->nullable();
            $table->string('user_type');
            $table->string('phone',20)->nullable();
            $table->string('password')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verify_token')->nullable();
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
