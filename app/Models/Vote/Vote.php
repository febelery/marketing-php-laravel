<?php

namespace App\Models\Vote;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use function now;

class Vote extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['setting'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }

    public function setting(): MorphOne
    {
        return $this->morphOne(Setting::class, 'settingable');
    }

    public function getRuntimeAttribute(): string
    {
        return $this->start_at . ' ~ ' . $this->end_at;
    }

    public function getActiveAttribute(): bool
    {
        return $this->start_at <= now() && $this->end_at >= now() && $this->is_public;
    }

    public function getVoteCountAttribute(): int
    {
        return $this->items->sum('vote_count');
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

}
