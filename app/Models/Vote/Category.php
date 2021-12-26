<?php

namespace App\Models\Vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $table = 'vote_categories';

    protected $guarded = [];

    public $timestamps = false;

    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }

}
