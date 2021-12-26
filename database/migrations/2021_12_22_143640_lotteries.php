<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Lotteries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->text('desc');

            $table->unsignedInteger('daily_limit')->default(0)->comment('每日限制');
            $table->unsignedInteger('total_limit')->default(1)->comment('总限制');
            $table->unsignedInteger('lucky_limit')->default(1)->comment('幸运限制');
            $table->unsignedInteger('daily_share_limit')->default(0)->comment('每日分享增加次数');
            $table->unsignedInteger('total_share_limit')->default(0)->comment('总共分享增加次数');
            $table->unsignedDecimal('lucky_rate')->nullable()->comment('幸运概率');
            $table->unsignedTinyInteger('type')->default(1)->comment('1:默认,2:积分抽奖,3:投票抽奖,4:表单抽奖');
            $table->unsignedInteger('type_value')->default(0)->comment('type value');
            $table->unsignedTinyInteger('template')->default(1)->comment('1:大转盘,2:九宫格,3:老虎机,4:翻牌机,5:砸金蛋,6:刮刮卡');

            $table->string('verify_code')->default('cgnews')->comment('核销码');
            $table->boolean('is_public')->default(false)->comment('是否公开');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
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
        Schema::dropIfExists('lotteries');
    }
}
