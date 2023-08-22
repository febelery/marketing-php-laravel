<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LotteryPrizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('lottery_prizes', function (Blueprint $table) {
            $table->id();
            $table->integer('lottery_id')->index();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('desc')->nullable();

            $table->unsignedDecimal('weight')->default(0)->comment('权重');
            $table->unsignedInteger('total')->default(0)->comment('奖品总数');
            $table->unsignedInteger('lucky_total')->default(0)->comment('中奖次数');
            $table->unsignedInteger('lucky_limit')->default(0)->comment('最大中奖次数');
            $table->unsignedTinyInteger('type')->default(1)->comment('1:实物 2:积分 3:红包');
            $table->unsignedInteger('type_value')->nullable()->comment('type value');

            $table->boolean('is_public')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::DropIfExists('lottery_prizes');
    }
}
