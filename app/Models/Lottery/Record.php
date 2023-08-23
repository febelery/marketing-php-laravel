<?php

namespace App\Models\Lottery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    use HasFactory;

    protected $table = 'lottery_records';

    protected $fillable = ['status'];

    protected $casts = [];

    public function lottery(): BelongsTo
    {
        return $this->belongsTo(Lottery::class);
    }

    public function prize(): BelongsTo
    {
        return $this->belongsTo(Prize::class);
    }

    public function scopeLuckyGuys($query)
    {
        return $query->where('status', '>', 0);
    }

    public function getDeliveryAttribute(): string
    {
        return match ($this->delivery_type) {
            null => '无',
            1 => '自提',
            2 => '邮寄',
        };
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            1 => '中奖',
            2 => '领取',
        };
    }
}
