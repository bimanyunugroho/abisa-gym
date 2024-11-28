<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Equipment extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentFactory> */
    use HasFactory, SoftDeletes, HasSlug, LogsActivity;

    protected $table = 'equipments';
    
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'usage_instructions',
        'brand',
        'model',
        'purchase_date',
        'last_maintenance_date',
        'condition',
        'is_active',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Master Alat')
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName}: {$this->name}";
            });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name', 'brand', 'model', 'category_id'])
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
            'purchase_date' => 'date',
            'last_maintenance_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }
}
