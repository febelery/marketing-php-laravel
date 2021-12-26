<?php

namespace App\Models\Lottery;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Lottery extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setting(): MorphOne
    {
        return $this->morphOne(Setting::class, 'settingable');
    }

    public function prizes(): HasMany
    {
        return $this->hasMany(Prize::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }

    public function getRuntimeAttribute(): string
    {
        return $this->start_at . ' ~ ' . $this->end_at;
    }

    public function getActiveAttribute(): bool
    {
        return $this->start_at <= now() && $this->end_at >= now() && $this->is_public;
    }

    public function getRecordUserAttribute(): int
    {
        return $this->records()->groupBy('user_id')->count();
    }

    public function getViewCountAttribute(): int
    {
        // todo 页面浏览量
        return 0;
    }

    public function getRemainPrizeAttribute(): int
    {
        return $this->prizes()->selectRaw('sum(total) - sum(lucky_count) as count')->first()->count;
    }
}
