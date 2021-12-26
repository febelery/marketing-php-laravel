<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VoteItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('vote_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->unsignedInteger('serial_number')->default(0);
            $table->text('desc');
            $table->json('images')->comment('图片');

            $table->unsignedInteger('vote_count')->default(0);
            $table->unsignedInteger('cheat_count')->default(0);
            $table->unsignedInteger('real_count')->default(0);

            $table->boolean('is_public')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['vote_id', 'serial_number']);

            //$table->foreign('category_id')->references('id')->on('vote_categories')
            //    ->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote_items');
    }
}
