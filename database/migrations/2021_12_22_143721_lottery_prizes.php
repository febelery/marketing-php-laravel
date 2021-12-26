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
    public function up()
    {
        Schema::create('lottery_prizes', function (Blueprint $table) {
            $table->id();
            $table->integer('lottery_id')->index();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->text('desc')->nullable();

            $table->unsignedDecimal('weight')->default(0)->comment('权重');
            $table->unsignedInteger('total')->default(0)->comment('奖品总数');
            $table->unsignedInteger('lucky_count')->default(0)->comment('中奖次数');
            $table->unsignedInteger('limit_times')->default(0)->comment('限制中奖次数');
            $table->unsignedTinyInteger('type')->default(1)->comment('1:实物 2:虚拟 3:积分 4:红包');
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
    public function down()
    {
        Schema::DropIfExists('lottery_prizes');
    }
}
