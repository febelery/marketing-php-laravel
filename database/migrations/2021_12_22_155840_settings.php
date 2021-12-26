<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Settings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('settingable_id');
            $table->string('settingable_type');

            $table->boolean('is_app')->default(true)->comment('APP限制');
            $table->boolean('is_wechat')->default(true)->comment('微信限制');
            $table->boolean('is_wechat_app')->default(false)->comment('微信小程序限制');
            $table->boolean('is_wechat_web')->default(false)->comment('微信网站限制');
            $table->boolean('is_anon')->default(false)->comment('匿名投票');
            $table->boolean('is_share')->default(true)->comment('是否可以分享');
            $table->string('share_title')->nullable()->comment('分享标题');
            $table->string('share_desc')->nullable()->comment('分享描述');
            $table->string('share_image')->nullable()->comment('分享图片');

            $table->unique(['settingable_type', 'settingable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
