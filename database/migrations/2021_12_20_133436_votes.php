<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Votes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('lottery_id')->nullable()->comment('投票后抽奖');
            $table->string('title');
            $table->text('desc');
            $table->string('cover');

            $table->unsignedInteger('daily_limit')->default(1)->comment('每日投票次数');
            $table->unsignedInteger('single_limit')->default(0)->comment('单人投票次数');
            $table->unsignedInteger('total_limit')->default(0)->comment('总投票次数');

            $table->unsignedInteger('sort')->default(0)->comment('0-票数,1-序号');
            $table->unsignedInteger('template')->default(0)->comment('模板');
            $table->unsignedInteger('column')->default(2)->comment('列数');
            $table->string('button_name')->nullable()->default('投票')->comment('按钮名称');
            $table->string('theme_color')->default('#ff0000')->comment('按钮颜色');
            $table->boolean('is_show_countdown')->default(true)->comment('是否显示倒计时');
            $table->boolean('is_show_statistics')->default(true)->comment('是否显示统计');
            $table->boolean('is_show_search')->default(true)->comment('是否显示搜索');
            $table->boolean('is_only_show')->default(false)->comment('是否只显示');

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
        Schema::dropIfExists('votes');
    }
}
