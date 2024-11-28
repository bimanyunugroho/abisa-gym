<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EquipmentCategory extends Model
{
    use HasFactory, SoftDeletes, HasSlug, LogsActivity;

    protected $fillable = [
        'name',
        'slug',
        'difficulty_level',
        'needs_supervision',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Master Kategori Alat')
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName}: {$this->name}";
            });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name', 'difficulty_level'])
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'needs_supervision' => 'boolean',
        ];
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'category_id');
    }
}
