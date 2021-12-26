<?php

namespace App\Models\Vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    use HasFactory;

    protected $table = 'vote_records';

    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

}
