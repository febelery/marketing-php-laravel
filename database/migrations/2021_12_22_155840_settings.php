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
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid()->primary();

            $table->boolean('allow_cgxw')->nullable()->comment('川观新闻限制');
            $table->string('bind_phone')->nullable()->comment('绑定电话');
            $table->string('bind_wechat')->nullable()->comment('绑定微信');
            $table->boolean('allow_wechat')->nullable()->comment('微信限制');
            $table->boolean('allow_wechat_app')->nullable()->comment('微信小程序限制');
            $table->boolean('allow_wechat_web')->nullable()->comment('微信网站限制');
            $table->boolean('allow_anon')->nullable()->comment('匿名投票');
            $table->boolean('allow_share')->nullable()->comment('是否可以分享');
            $table->string('share_title')->nullable()->comment('分享标题');
            $table->string('share_desc')->nullable()->comment('分享描述');
            $table->string('share_image')->nullable()->comment('分享图片');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
}
