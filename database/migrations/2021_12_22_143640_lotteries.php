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
    public function up(): void
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->uuid()->primary();

            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->text('desc');

            $table->unsignedInteger('daily_limit')->default(0)->comment('每日限制');
            $table->unsignedInteger('total_limit')->default(1)->comment('总限制');
            $table->unsignedInteger('lucky_limit')->default(1)->comment('中奖次数限制');
            $table->unsignedDecimal('lucky_rate')->nullable()->comment('幸运概率');
            $table->unsignedInteger('cost_integral')->nullable()->comment('消耗积分');
            $table->unsignedTinyInteger('template')->default(1)->comment('1:大转盘,2:九宫格,3:老虎机,4:翻牌机,5:砸金蛋,6:刮刮卡');

            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('lotteries');
    }
}
