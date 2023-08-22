<?php

namespace App\Models\Lottery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prize extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'lottery_prizes';

    public function lottery(): BelongsTo
    {
        return $this->belongsTo(Lottery::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }

    public function getRemainAttribute()
    {
        return $this->total - $this->lucky_total;
    }
}
