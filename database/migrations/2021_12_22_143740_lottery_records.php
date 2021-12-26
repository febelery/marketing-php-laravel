<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LotteryRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_records', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('lottery_id')->unsigned();
            $table->integer('prize_id')->unsigned();

            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('id_card')->nullable();
            $table->string('remark')->nullable()->comment('备注');
            $table->string('code')->nullable();
            $table->tinyInteger('delivery_type')->default(0)->comment('0:自提,1:邮寄');
            $table->unsignedTinyInteger('get_type')->default(0)->comment('0:默认,1:分享');
            $table->unsignedTinyInteger('status')->default(0)->comment('中奖状态');

            $table->ipAddress('ip');
            $table->timestamps();

            $table->index(['lottery_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lottery_records');
    }
}
