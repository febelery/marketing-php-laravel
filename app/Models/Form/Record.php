<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    use HasFactory;

    protected $table = 'form_records';

    protected $casts = [
        'record' => 'array',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function getAttribute($key)
    {
        if (str_starts_with($key, "record->")) {
            $record = parent::getAttribute("record");
            return $record[str_replace("record->", "", $key)];
        } else {
            return parent::getAttribute($key);
        }
    }

}
