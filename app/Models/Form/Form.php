<?php

namespace App\Models\Form;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function setting(): MorphOne
    {
        return $this->morphOne(Setting::class, 'settingable');
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

    public function getViewCountAttribute(): int
    {
        // todo 页面浏览量
        return 0;
    }

    public function getRecordUserAttribute(): int
    {
        return $this->records()->count();
    }

    public function setFieldsAttribute($value)
    {
        $this->attributes['fields'] = collect($value)->values()->toJson();
    }

    public function getFieldsAttribute(): array
    {
        $fields = [];

        if (empty($this->attributes['fields']) || $this->attributes['fields'] == null) return $fields;

        foreach (json_decode($this->attributes['fields']) as $key => $field) {
            $fields[sprintf('%02d%s', $key + 1, substr(Str::uuid()->toString(), 2))] = $field;
        }

        return $fields;
    }


}
