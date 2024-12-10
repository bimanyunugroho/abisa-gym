<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class GymVisit extends Model
{
    /** @use HasFactory<\Database\Factories\GymVisitFactory> */
    use HasFactory, SoftDeletes, HasSlug, LogsActivity;

    protected $fillable = [
        'user_id',
        'member_registration_id',
        'guest_of',
        'check_in_time',
        'check_out_time',
        'slug',
        'visit_type',
        'paid_amount',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in_time' => 'datetime',
            'check_out_time' => 'datetime',
            'paid_amount' => 'decimal:2',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Kunjungan Ke Gym')
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName}: {$this->user_id} - {$this->member_registration_id} - {$this->guest_of} - {$this->visit_type}";
            });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['user_id', 'member_registration_id', 'guest_of', 'visit_type'])
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

    public function memberRegistration()
    {
        return $this->belongsTo(MemberRegistration::class);
    }

    public function guestOf()
    {
        return $this->belongsTo(User::class, 'guest_of');
    }

    public function payment()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
