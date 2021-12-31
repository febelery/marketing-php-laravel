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
            $table->unsignedBigInteger('uid')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('id_card', 25)->nullable();
            $table->string('app', 30);
            $table->string('app_id', 50);
            $table->string('union_id', 50)->nullable();
            $table->timestamps();

            $table->unique(['mobile', 'app']);
            $table->index(['app', 'app_id']);
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
