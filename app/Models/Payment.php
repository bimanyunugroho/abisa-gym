<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'payable_id',
        'payable_type',
        'slug',
        'no_payment',
        'amount',
        'payment_method',
        'payment_type',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Payment')
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName}: {$this->no_payment}";
            });
    }

    protected function generateSlug($source)
    {
        return strtolower(str_replace('-', '', $source));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->no_payment)) {
                $payment->no_payment = static::generatePaymentNumber();
            }
            
            if (empty($payment->slug)) {
                $payment->slug = $payment->generateSlug($payment->no_payment);
            }
        });
    }

    protected static function generatePaymentNumber(): string
    {
        $prefix = 'PAY';
        $date = Carbon::now()->format('Ymd');
        
        $lastNumber = static::where('no_payment', 'like', "{$prefix}-{$date}-%")
            ->orderBy('no_payment', 'desc')
            ->first();

        $sequence = $lastNumber ? 
            (int) substr($lastNumber->no_payment, -4) + 1 : 
            1;

        return sprintf("%s-%s-%04d", $prefix, $date, $sequence);
    }
}
