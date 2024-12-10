<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MemberRegistration extends Model
{
    /** @use HasFactory<\Database\Factories\MemberRegistrationFactory> */
    use HasFactory, SoftDeletes, HasSlug, LogsActivity;

    protected $fillable = [
        'user_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'visits_left',
        'status',
        'orientation_date',
        'orientation_completed',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'orientation_date' => 'date',
            'orientation_completed' => 'boolean',
            'visits_left' => 'integer',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Registrasi Anggota')
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName}: {$this->user_id} - {$this->membership_plan_id} - {$this->status}";
            });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['user_id', 'membership_plan_id', 'status'])
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

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function gymVisits()
    {
        return $this->hasMany(GymVisit::class);
    }
}
