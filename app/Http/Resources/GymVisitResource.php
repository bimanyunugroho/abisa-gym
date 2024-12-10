<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GymVisitResource extends JsonResource
{
    /**
     * Initialize the resource instance.
     *
     * @return void
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        static::withoutWrapping();
    }
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'member_registration_id' => $this->member_registration_id,
            'guest_of' => $this->guest_of,
            'user' => new UserResource($this->whenLoaded('user')),
            'member_registration' => new MemberRegistrationResource($this->whenLoaded('memberRegistration')),
            'guest' => new UserResource($this->whenLoaded('guestOf')),
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
            'slug' => $this->slug,
            'visit_type' => $this->visit_type,
            'paid_amount' => $this->paid_amount,
            'notes' => $this->notes,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
