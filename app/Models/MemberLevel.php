<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MemberLevel extends Model
{
    /** @use HasFactory<\Database\Factories\MemberInductionFactory> */
    use HasFactory, SoftDeletes, HasSlug, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'can_train_without_trainer',
        'needs_orientation',
        'has_trainer_access',
        'max_guests',
        'guest_fee',
    ];

    protected function casts(): array
    {
        return [
            'can_train_without_trainer' => 'boolean',
            'needs_orientation' => 'boolean',
            'has_trainer_access' => 'boolean',
            'max_guests' => 'integer',
            'guest_fee' => 'decimal:2',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Level Anggota')
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName}: {$this->name}";
            });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name'])
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
