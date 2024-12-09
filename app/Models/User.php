<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Enums\RoleEnum;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasSlug, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'gym_number',
        'email',
        'password',
        'role',
        'phone_number',
        'address',
        'birth_date',
        'gender',
        'health_conditions',
        'emergency_contact',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date'
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('User')
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName}: {$this->name} - {$this->email}";
            });
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name', 'email'])
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function inductions()
    {
        return $this->hasMany(MemberInduction::class);
    }

    public function conductedInductions()
    {
        return $this->hasMany(MemberInduction::class, 'trainer_id');
    }

    public function memberRegistrations()
    {
        return $this->hasMany(MemberRegistration::class);
    }

    public function gymVisits()
    {
        return $this->hasMany(GymVisit::class);
    }

    public function guestOf()
    {
        return $this->hasMany(GymVisit::class, 'guest_of');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->role) {
                $user->role = RoleEnum::MEMBER->value;
            }

            if (in_array($user->role, [RoleEnum::ADMIN->value, RoleEnum::TRAINER->value, RoleEnum::MEMBER->value])) {
                $user->gym_number = static::generateGymNumber($user->role);
            }
        });
    }

    protected static function generateGymNumber($role): string
    {
        $prefix = match ($role) {
            RoleEnum::ADMIN->value => 'ADM',
            RoleEnum::TRAINER->value => 'TRN',
            RoleEnum::MEMBER->value => 'MBR',
            RoleEnum::OWNER->value => 'OWN',
            RoleEnum::SUPER_ADMIN->value => 'GST',
            default => throw new \InvalidArgumentException('Invalid role for gym number generation')
        };

        $date = Carbon::now()->format('Ymd');
        
        $lastNumber = static::where('gym_number', 'like', "{$prefix}-{$date}-%")
            ->orderBy('gym_number', 'desc')
            ->first();

        $sequence = $lastNumber ? 
            (int) substr($lastNumber->gym_number, -4) + 1 : 
            1;

        return sprintf("%s-%s-%04d", $prefix, $date, $sequence);
    }
}
