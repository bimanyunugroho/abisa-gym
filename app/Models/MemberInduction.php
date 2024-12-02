<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MemberInduction extends Model
{
    /** @use HasFactory<\Database\Factories\MemberInductionFactory> */
    use HasFactory, SoftDeletes, HasSlug, LogsActivity;

    protected $fillable = [
        'user_id',
        'trainer_id',
        'equipment_category_id',
        'slug',
        'induction_date',
        'notes',
        'is_completed',
    ];

    protected function casts(): array
    {
        return [
            'induction_date' => 'date',
            'is_completed' => 'boolean',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Induksi Anggota')
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName}: {$this->user_id} - {$this->trainer_id} - {$this->equipment_category_id} - {$this->induction_date}";
            });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['user_id', 'trainer_id', 'equipment_category_id', 'induction_date'])
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function equipmentCategory()
    {
        return $this->belongsTo(EquipmentCategory::class);
    }
}
