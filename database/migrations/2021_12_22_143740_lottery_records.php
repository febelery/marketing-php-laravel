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
    public function up(): void
    {
        Schema::create('lottery_records', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('lottery_id')->unsigned();
            $table->integer('prize_id')->unsigned();

            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('idcard')->nullable();
            $table->string('remark')->nullable()->comment('备注');
            $table->string('code')->nullable();
            $table->string('express')->nullable()->comment('快递单号');
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
    public function down(): void
    {
        Schema::dropIfExists('lottery_records');
    }
}
